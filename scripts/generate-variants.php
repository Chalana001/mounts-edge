<?php
/**
 * Generates downscaled variants alongside each source image, for srcset and for
 * the hero thumbnail strip.
 *
 * Variants are written next to the original as <name>-<width>w.<ext>, e.g.
 *   home/hero/pool4.jpg -> home/hero/pool4-400w.jpg
 *
 * A width larger than the source is skipped rather than upscaled, and a variant
 * that lands no smaller than the file it came from is discarded -- the caller
 * can then just fall back to the original.
 *
 * Usage, from the project root:
 *   php scripts/generate-variants.php --dry-run
 *   php scripts/generate-variants.php
 *   php scripts/generate-variants.php --clean    # remove every generated variant
 */

const SRC = __DIR__ . '/../storage/app/public';

/**
 * Prefix => widths. Longest prefix wins, so the hero entry must precede any
 * broader 'home/' rule if one is ever added.
 */
const TARGETS = [
    // Hero thumbnail strip: cards cap at 180px wide (see cardWidth() in
    // hero-section), so 400w covers 2x DPR. The 1000w keeps a mid-size option
    // for the background on small viewports.
    'home/hero/'              => [400, 1000],

    // Moment cards render ~270px wide; 400/800 covers 1x and 2x.
    'home/signature-moments/' => [400, 800],

    // Full-width section backgrounds and inline cards.
    'home/experiences/'       => [800, 1200],
    'home/pool-highlight.jpg' => [600, 1200],

    // Page heroes on the secondary pages.
    'hero-images/'            => [800, 1400],

    // Gallery masonry tiles: ~300px column, but the lightbox wants the full
    // file, so the original stays as the largest srcset candidate.
    'gallery/'                => [400, 800],

    'weddings/highlights/'    => [400, 800],
];

$args   = array_slice($argv, 1);
$dryRun = in_array('--dry-run', $args, true);
$clean  = in_array('--clean', $args, true);

if (!extension_loaded('gd')) {
    fwrite(STDERR, "ext-gd is required.\n");
    exit(1);
}

if ($clean) {
    cleanVariants();
    exit(0);
}

$made = 0; $skipped = 0; $bytes = 0;
printf("%-46s %8s %8s  %s\n", 'VARIANT', 'WIDTH', 'SIZE', 'NOTE');
echo str_repeat('-', 86) . "\n";

foreach (sources() as $path) {
    $rel = relativeTo($path, SRC);
    $widths = widthsFor($rel);
    if (!$widths) continue;

    $info = @getimagesize($path);
    if ($info === false) continue;
    [$w, $h, $type] = $info;

    foreach ($widths as $tw) {
        if ($tw >= $w) { $skipped++; continue; }   // never upscale

        $out = variantPath($path, $tw);
        $relOut = relativeTo(dirname($path), SRC) . '/' . basename($out);
        $relOut = ltrim($relOut, '/');

        if ($dryRun) {
            printf("%-46s %8d %8s  %s\n", trim46($relOut), $tw, '-', "from {$w}x{$h}");
            $made++;
            continue;
        }

        $size = writeVariant($path, $out, $type, $w, $h, $tw);
        if ($size === false) { $skipped++; continue; }

        // A variant that saves nothing is dead weight; drop it.
        if ($size >= filesize($path)) {
            @unlink($out);
            $skipped++;
            printf("%-46s %8d %8s  %s\n", trim46($relOut), $tw, '-', 'no saving, dropped');
            continue;
        }

        $made++; $bytes += $size;
        printf("%-46s %8d %8s  %s\n", trim46($relOut), $tw, fmt($size), "from {$w}x{$h}");
    }
}

echo str_repeat('-', 86) . "\n";
printf("%d variants %s, %d skipped, %s added\n",
    $made, $dryRun ? 'would be created' : 'created', $skipped, fmt($bytes));
if ($dryRun) echo "(no files were written)\n";

// ---------------------------------------------------------------- helpers

function sources(): array {
    $out = [];
    $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(SRC, FilesystemIterator::SKIP_DOTS));
    foreach ($it as $f) {
        if (!$f->isFile()) continue;
        $name = $f->getFilename();
        if (!preg_match('/\.(jpe?g|jfif|png|webp)$/i', $name)) continue;
        if (isVariant($name)) continue;              // never chain off a variant
        $out[] = $f->getPathname();
    }
    sort($out);
    return $out;
}

function isVariant(string $filename): bool {
    return (bool) preg_match('/-\d+w\.[a-z]+$/i', $filename);
}

function widthsFor(string $rel): array {
    $best = null; $bestLen = -1;
    foreach (TARGETS as $prefix => $widths) {
        if (str_starts_with($rel, $prefix) && strlen($prefix) > $bestLen) {
            $best = $widths; $bestLen = strlen($prefix);
        }
    }
    return $best ?? [];
}

function variantPath(string $path, int $w): string {
    $dir  = dirname($path);
    $ext  = pathinfo($path, PATHINFO_EXTENSION);
    $base = pathinfo($path, PATHINFO_FILENAME);
    return $dir . DIRECTORY_SEPARATOR . $base . '-' . $w . 'w.' . $ext;
}

function writeVariant(string $src, string $dst, int $type, int $w, int $h, int $tw) {
    switch ($type) {
        case IMAGETYPE_JPEG: $im = @imagecreatefromjpeg($src); break;
        case IMAGETYPE_PNG:  $im = @imagecreatefrompng($src);  break;
        case IMAGETYPE_WEBP: $im = @imagecreatefromwebp($src); break;
        default: return false;
    }
    if (!$im) return false;

    $th  = max(1, (int) round($h * ($tw / $w)));
    $dstIm = imagecreatetruecolor($tw, $th);
    if ($type === IMAGETYPE_PNG || $type === IMAGETYPE_WEBP) {
        imagealphablending($dstIm, false);
        imagesavealpha($dstIm, true);
    }
    imagecopyresampled($dstIm, $im, 0, 0, 0, 0, $tw, $th, $w, $h);
    imagedestroy($im);

    $ok = false;
    switch ($type) {
        case IMAGETYPE_JPEG: imageinterlace($dstIm, true); $ok = imagejpeg($dstIm, $dst, 78); break;
        case IMAGETYPE_PNG:  $ok = imagepng($dstIm, $dst, 9); break;
        case IMAGETYPE_WEBP: $ok = imagewebp($dstIm, $dst, 78); break;
    }
    imagedestroy($dstIm);
    clearstatcache(true, $dst);

    return $ok ? filesize($dst) : false;
}

function cleanVariants(): void {
    $n = 0; $freed = 0;
    $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(SRC, FilesystemIterator::SKIP_DOTS));
    foreach ($it as $f) {
        if (!$f->isFile()) continue;
        if (!isVariant($f->getFilename())) continue;
        $freed += $f->getSize();
        if (@unlink($f->getPathname())) $n++;
    }
    printf("Removed %d variants, freed %s\n", $n, fmt($freed));
}

function relativeTo(string $path, string $base): string {
    $b = str_replace(DIRECTORY_SEPARATOR, '/', realpath($base) ?: $base);
    $p = str_replace(DIRECTORY_SEPARATOR, '/', realpath($path) ?: $path);
    return ltrim(substr($p, strlen($b)), '/');
}

function fmt(int $b): string {
    return $b >= 1048576 ? sprintf('%.1f MB', $b / 1048576) : sprintf('%d KB', (int) round($b / 1024));
}

function trim46(string $s): string {
    return strlen($s) <= 46 ? $s : '...' . substr($s, -43);
}
