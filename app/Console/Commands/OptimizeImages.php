<?php

namespace App\Console\Commands;

use App\Services\ImageOptimizer;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

/**
 * Re-encodes everything under storage/app/public and emits srcset variants.
 *
 * New uploads are handled automatically by ImageOptimizer, so this exists for
 * the cases that bypass it: the initial cleanup of an existing library, files
 * copied onto the server by hand, and anything restored from a backup.
 *
 * Safe to re-run -- an already-optimised file re-encodes no smaller and is left
 * alone, and variants are skipped when they already exist.
 */
class OptimizeImages extends Command
{
    protected $signature = 'images:optimize
                            {--dry-run : Report what would change without writing}
                            {--force : Regenerate variants that already exist}';

    protected $description = 'Resize and re-encode images in storage/app/public, and generate srcset variants';

    /** Longest edge per top-level folder; mirrors ImageOptimizer::CAPS. */
    protected array $caps = [
        'home'         => 1600,
        'hero-images'  => 1600,
        'gallery'      => 1500,
        'weddings'     => 1500,
        'rooms'        => 1400,
        'dining'       => 1400,
        'experiences'  => 1200,
    ];

    /**
     * Variant widths by path prefix, longest match wins.
     *
     * These mirror the widths the templates actually ask for -- generating any
     * other width just leaves files on disk that nothing ever requests. When you
     * add a srcset to a template, add its widths here.
     */
    protected array $variants = [
        'home/hero/'              => [400, 1000],   // hero thumbnails + pool-relaxation
        'home/signature-moments/' => [400, 800],
        'home/experiences/'       => [800, 1200],
        'home/pool-highlight'     => [600, 1200],
        // page-hero probes these; 400 also covers the home hero's thumbnail
        // strip, which now sources one of its slides from here.
        'hero-images/'            => [400, 800, 1400],
        'gallery/'                => [400, 800],
        'weddings/highlights/'    => [400, 800],
    ];

    public function handle(ImageOptimizer $optimizer): int
    {
        if (! extension_loaded('gd')) {
            $this->error('ext-gd is required.');

            return self::FAILURE;
        }

        $disk = Storage::disk('public');
        $dryRun = (bool) $this->option('dry-run');

        $files = collect($disk->allFiles())
            ->filter(fn ($p) => preg_match('/\.(jpe?g|jfif|png|webp)$/i', $p))
            // Never re-encode a variant: it would compound compression artefacts
            // and the next run would do it again.
            ->reject(fn ($p) => preg_match('/-\d+w\.[a-z]+$/i', $p))
            // Nor a .webp this command generated. Some .webp files are genuine
            // originals (Knuckles, yoga-session), so they are told apart by
            // whether a same-named raster sibling exists to have derived from.
            ->reject(fn ($p) => $this->isDerivedWebp($disk->path($p)))
            ->values();

        if ($files->isEmpty()) {
            $this->warn('No images found under storage/app/public.');

            return self::SUCCESS;
        }

        $before = 0;
        $after = 0;
        $touched = 0;
        $made = 0;
        $webp = 0;
        $skipped = 0;

        // Records the checksum of each file as this command left it. Re-encoding
        // an already-processed JPEG shrinks it a little every pass while
        // compounding artefacts, so "already lean" is not a reliable stop
        // condition -- detailed photos genuinely need more bytes per pixel.
        // Matching the recorded checksum is exact, and a replaced file simply
        // fails to match and gets processed again.
        $manifest = $this->option('force') ? [] : $this->loadManifest();

        $bar = $this->output->createProgressBar($files->count());
        $bar->start();

        foreach ($files as $relative) {
            $absolute = $disk->path($relative);
            $size = filesize($absolute);
            $before += $size;

            $folder = strtok($relative, '/');
            $cap = $this->caps[$folder] ?? 1400;
            $widths = $this->variantsFor($relative);

            if ($dryRun) {
                $after += $size;
                $bar->advance();
                continue;
            }

            if (($manifest[$relative] ?? null) === md5_file($absolute)) {
                $skipped++;
                $after += $size;
                $bar->advance();
                continue;
            }

            $result = $optimizer->optimize($absolute, $cap);
            if ($result !== null) {
                $touched++;
            }
            $after += $result ?? $size;

            if ($widths) {
                if ($this->option('force')) {
                    $optimizer->forget($absolute);
                }
                $made += count($optimizer->makeVariants($absolute, $widths));
            }

            // Runs for every image, variants or not: a lone <img> still benefits
            // from a WebP <source>. Kept only where it beats the original by a
            // worthwhile margin, so the count here is lower than the file count.
            $webp += count($optimizer->makeWebp($absolute));

            $manifest[$relative] = md5_file($absolute);

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        if (! $dryRun) {
            $this->saveManifest($manifest);
            if ($skipped) {
                $this->line("{$skipped} already optimised, left untouched.");
            }
        }

        if ($dryRun) {
            $this->info(sprintf('%d images, %s on disk. Re-run without --dry-run to optimise.',
                $files->count(), $this->format($before)));

            return self::SUCCESS;
        }

        $this->info(sprintf(
            '%d images scanned, %d re-encoded, %d variants written, %d webp written.',
            $files->count(), $touched, $made, $webp
        ));
        $this->line(sprintf(
            'Originals: %s -> %s (%.1f%% smaller)',
            $this->format($before), $this->format($after),
            $before > 0 ? (1 - $after / $before) * 100 : 0
        ));

        return self::SUCCESS;
    }

    /**
     * True when this .webp was generated from a neighbouring raster file, as
     * opposed to being an original that was uploaded as WebP in the first place.
     */
    protected function isDerivedWebp(string $absolute): bool
    {
        if (strtolower(pathinfo($absolute, PATHINFO_EXTENSION)) !== 'webp') {
            return false;
        }

        $stem = substr($absolute, 0, -strlen('webp'));

        foreach (['jpg', 'jpeg', 'jfif', 'png', 'JPG'] as $ext) {
            if (is_file($stem . $ext)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Longest matching prefix wins, so 'home/hero/' beats a broader 'home/'.
     *
     * @return array<int, int>
     */
    protected function variantsFor(string $relative): array
    {
        $best = [];
        $bestLength = -1;

        foreach ($this->variants as $prefix => $widths) {
            if (str_starts_with($relative, $prefix) && strlen($prefix) > $bestLength) {
                $best = $widths;
                $bestLength = strlen($prefix);
            }
        }

        return $best;
    }

    /**
     * Lives outside storage/app/public so it is never web-served, and is
     * disposable -- deleting it just means the next run reprocesses everything.
     *
     * @return array<string, string>
     */
    protected function loadManifest(): array
    {
        $path = storage_path('app/image-optimizer.json');

        if (! is_file($path)) {
            return [];
        }

        $decoded = json_decode((string) file_get_contents($path), true);

        return is_array($decoded) ? $decoded : [];
    }

    /**
     * @param  array<string, string>  $manifest
     */
    protected function saveManifest(array $manifest): void
    {
        ksort($manifest);

        file_put_contents(
            storage_path('app/image-optimizer.json'),
            json_encode($manifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
        );
    }

    protected function format(int $bytes): string
    {
        return $bytes >= 1048576
            ? sprintf('%.1f MB', $bytes / 1048576)
            : sprintf('%d KB', (int) round($bytes / 1024));
    }
}
