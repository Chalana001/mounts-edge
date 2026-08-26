<?php
/**
 * One-off / repeatable image optimiser for storage/app/public.
 *
 * Re-encodes photos in place, keeping every filename and extension exactly as
 * it was, so no Blade reference, seeder, or database row needs to change.
 * Originals are expected to already be backed up in storage/app/image-originals
 * (see --restore).
 *
 * Usage, from the project root:
 *   php scripts/optimize-images.php --audit     # report only, writes nothing
 *   php scripts/optimize-images.php --dry-run   # show what each file would become
 *   php scripts/optimize-images.php             # do it
 *   php scripts/optimize-images.php --restore   # copy the backup back over
 *
 * Requires ext-gd with JPEG support (bundled GD 2.1+ is fine).
 */

const SRC    = __DIR__ . '/../storage/app/public';
const BACKUP = __DIR__ . '/../storage/app/image-originals';

/**
 * Max edge by role. Directory-matched, first hit wins. Heroes go full-bleed on
 * a desktop viewport so they keep more pixels; cards and tiles never render
 * anywhere near their source size.
 */
const ROLES = [
    // Longest prefix first -- the first match wins.

    // Full-bleed backgrounds. The sources are square 2048s but the hero is a
    // 16:9 band, so bg-cover already discards ~44% of the pixels; 1600 upscales
    // ~17% on a 1920 viewport, which is invisible under the hero's own
    // black/60-to-black/90 gradient overlays.
    'home/hero/'               => ['max' => 1600, 'q' => 78, 'role' => 'full-bleed hero'],
    'hero-images/'             => ['max' => 1600, 'q' => 78, 'role' => 'page hero'],

    // 4-column grid inside max-w-6xl (1152px) with 24px gaps -> ~270px per
    // card, ~540px at 2x DPR. 800 leaves headroom and is still 4x smaller.
    'home/signature-moments/'  => ['max' => 800,  'q' => 78, 'role' => 'moment card'],
    'home/experiences/'        => ['max' => 1600, 'q' => 78, 'role' => 'section bg'],

    // Remaining home images are inline, not full-bleed: pool-highlight sits in
    // one half of a md:grid-cols-2 inside max-w-6xl, so ~544px wide (~1088 at 2x).
    'home/'                    => ['max' => 1200, 'q' => 78, 'role' => 'inline card'],

    // Tiles are ~300px, but the lightbox opens these full-screen, so they need
    // to stay large enough for that -- this is the one place size is driven by
    // the zoomed view rather than the thumbnail.
    'gallery/'                 => ['max' => 1500, 'q' => 78, 'role' => 'gallery + lightbox'],

    'weddings/highlights/'     => ['max' => 1200, 'q' => 78, 'role' => 'photo-spot tile'],
    'weddings/'                => ['max' => 1500, 'q' => 78, 'role' => 'hall slider'],
    'rooms/'                   => ['max' => 1400, 'q' => 78, 'role' => 'room card'],
    'experiences/'             => ['max' => 1200, 'q' => 78, 'role' => 'experience card'],
    'dining/'                  => ['max' => 1400, 'q' => 78, 'role' => 'dining card'],
];
const DEFAULT_ROLE = ['max' => 1400, 'q' => 78, 'role' => 'other'];

$args    = array_slice($argv, 1);
$audit   = in_array('--audit', $args, true);
$dryRun  = in_array('--dry-run', $args, true);
$restore = in_array('--restore', $args, true);

if ($restore) {
    restoreFromBackup();
    exit(0);
}

if (!extension_loaded('gd')) {
    fwrite(STDERR, "ext-gd is required.\n");
    exit(1);
}

$files = collectFiles(SRC);
if (!$files) {
    fwrite(STDERR, "No images found under " . SRC . "\n");
    exit(1);
}

printf("%-52s %10s %10s %9s  %s\n", 'FILE', 'BEFORE', 'AFTER', 'SAVED', 'DIMENSIONS');
echo str_repeat('-', 110) . "\n";

$totalBefore = 0;
$totalAfter  = 0;
$skipped     = [];
$rotated     = [];

foreach ($files as $path) {
    $rel    = relative($path);
    $before = filesize($path);
    $totalBefore += $before;

    $cfg  = roleFor($rel);
    $info = @getimagesize($path);

    if ($info === false) {
        $skipped[] = "$rel (unreadable)";
        $totalAfter += $before;
        continue;
    }

    [$w, $h, $type] = $info;

    // Flag EXIF-rotated JPEGs: GD drops EXIF on write, so a photo relying on an
    // orientation tag would silently flip. None are expected, but never assume.
    $orient = jpegOrientation($path);
    if ($orient !== null && $orient != 1) {
        $rotated[] = "$rel (orientation=$orient)";
        $totalAfter += $before;
        continue;
    }

    $scale  = min(1.0, $cfg['max'] / max($w, $h));
    $newW   = max(1, (int) round($w * $scale));
    $newH   = max(1, (int) round($h * $scale));

    if ($audit || $dryRun) {
        $dim = ($newW == $w && $newH == $h) ? "{$w}x{$h} (unchanged)" : "{$w}x{$h} -> {$newW}x{$newH}";
        printf("%-52s %10s %10s %9s  %s\n", trim52($rel), fmt($before), '-', '-', $dim . '  [' . $cfg['role'] . ']');
        $totalAfter += $before;
        continue;
    }

    $result = reencode($path, $type, $w, $h, $newW, $newH, $cfg['q']);

    if ($result === false) {
        $skipped[] = "$rel (encode failed)";
        $totalAfter += $before;
        continue;
    }

    // Never let the optimiser make a file bigger. Some already-tuned images
    // (small WebP, tiny JPEGs) come out worse; keep the original in that case.
    if ($result >= $before) {
        $skipped[] = "$rel (already optimal, kept original)";
        restoreOne($rel);
        $totalAfter += $before;
        continue;
    }

    $totalAfter += $result;
    $dim = ($newW == $w && $newH == $h) ? "{$w}x{$h}" : "{$w}x{$h} -> {$newW}x{$newH}";
    printf(
        "%-52s %10s %10s %8.1f%%  %s\n",
        trim52($rel), fmt($before), fmt($result),
        (1 - $result / $before) * 100, $dim
    );
}

echo str_repeat('-', 110) . "\n";
printf("%-52s %10s %10s %8.1f%%\n", 'TOTAL (' . count($files) . ' files)', fmt($totalBefore), fmt($totalAfter),
    $totalBefore ? (1 - $totalAfter / $totalBefore) * 100 : 0);

if ($rotated) {
    echo "\nSKIPPED - EXIF rotation would be lost, handle manually:\n";
    foreach ($rotated as $r) echo "  $r\n";
}
if ($skipped) {
    echo "\nSKIPPED:\n";
    foreach ($skipped as $s) echo "  $s\n";
}
if ($audit || $dryRun) {
    echo "\n(no files were written)\n";
}

// ---------------------------------------------------------------- helpers

function collectFiles(string $dir): array {
    $out = [];
    $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS));
    foreach ($it as $f) {
        if (!$f->isFile()) continue;
        if (preg_match('/\.(jpe?g|jfif|png|webp)$/i', $f->getFilename())) {
            $out[] = $f->getPathname();
        }
    }
    sort($out);
    return $out;
}

/**
 * Path of $path relative to $base.
 *
 * Both sides must be canonical: the iterator yields paths still containing the
 * "scripts/.." hop, which is longer than the resolved base. Trimming by the
 * resolved length then leaves a stray prefix on every result -- which, on the
 * restore path, meant writing the backup into a bogus subdirectory instead of
 * back over the originals. Always resolve both sides.
 */
function relativeTo(string $path, string $base): string {
    $b = str_replace(DIRECTORY_SEPARATOR, '/', realpath($base) ?: $base);
    $p = str_replace(DIRECTORY_SEPARATOR, '/', realpath($path) ?: $path);
    return ltrim(substr($p, strlen($b)), '/');
}

function relative(string $path): string {
    return relativeTo($path, SRC);
}

function roleFor(string $rel): array {
    foreach (ROLES as $prefix => $cfg) {
        if (str_starts_with($rel, $prefix)) return $cfg;
    }
    return DEFAULT_ROLE;
}

function reencode(string $path, int $type, int $w, int $h, int $newW, int $newH, int $q) {
    switch ($type) {
        case IMAGETYPE_JPEG: $im = @imagecreatefromjpeg($path); break;
        case IMAGETYPE_PNG:  $im = @imagecreatefrompng($path);  break;
        case IMAGETYPE_WEBP: $im = @imagecreatefromwebp($path); break;
        default: return false;
    }
    if (!$im) return false;

    if ($newW !== $w || $newH !== $h) {
        $dst = imagecreatetruecolor($newW, $newH);
        if ($type === IMAGETYPE_PNG || $type === IMAGETYPE_WEBP) {
            imagealphablending($dst, false);
            imagesavealpha($dst, true);
        }
        imagecopyresampled($dst, $im, 0, 0, 0, 0, $newW, $newH, $w, $h);
        imagedestroy($im);
        $im = $dst;
    }

    $ok = false;
    switch ($type) {
        case IMAGETYPE_JPEG:
            imageinterlace($im, true);          // progressive: renders top-down
            $ok = imagejpeg($im, $path, $q);
            break;
        case IMAGETYPE_PNG:
            // Photographs stored as PNG stay PNG here so the filename does not
            // change; max zlib compression is all that is safely available.
            $ok = imagepng($im, $path, 9);
            break;
        case IMAGETYPE_WEBP:
            $ok = imagewebp($im, $path, $q);
            break;
    }
    imagedestroy($im);
    clearstatcache(true, $path);

    return $ok ? filesize($path) : false;
}

function jpegOrientation(string $path) {
    $fh = fopen($path, 'rb');
    if (!$fh) return null;
    $d = fread($fh, 131072);
    fclose($fh);
    if (substr($d, 0, 2) !== "\xFF\xD8") return null;

    $i = 2; $n = strlen($d);
    while ($i < $n - 4) {
        if ($d[$i] !== "\xFF") { $i++; continue; }
        $m = ord($d[$i + 1]);
        if ($m === 0xD8 || $m === 0x01 || ($m >= 0xD0 && $m <= 0xD7)) { $i += 2; continue; }
        if ($m === 0xDA || $m === 0xD9) return null;
        if ($i + 4 > $n) return null;
        $len = unpack('n', substr($d, $i + 2, 2))[1];

        if ($m === 0xE1 && substr($d, $i + 4, 6) === "Exif\0\0") {
            $tiff = $i + 10;
            $bo   = substr($d, $tiff, 2);
            if ($bo !== 'II' && $bo !== 'MM') return null;
            $le = ($bo === 'II');
            $u32 = function ($o) use ($d, $le) { return unpack($le ? 'V' : 'N', substr($d, $o, 4))[1]; };
            $u16 = function ($o) use ($d, $le) { return unpack($le ? 'v' : 'n', substr($d, $o, 2))[1]; };
            $ifd = $tiff + $u32($tiff + 4);
            if ($ifd + 2 > $n) return null;
            $cnt = $u16($ifd);
            for ($e = 0; $e < $cnt; $e++) {
                $ent = $ifd + 2 + $e * 12;
                if ($ent + 12 > $n) return null;
                if ($u16($ent) === 0x0112) return $u16($ent + 8);
            }
            return null;
        }
        $i += 2 + $len;
    }
    return null;
}

function restoreOne(string $rel): void {
    $from = BACKUP . '/' . $rel;
    if (is_file($from)) copy($from, SRC . '/' . $rel);
}

function restoreFromBackup(): void {
    if (!is_dir(BACKUP)) {
        fwrite(STDERR, "No backup at " . BACKUP . "\n");
        exit(1);
    }
    $n = 0;
    $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(BACKUP, FilesystemIterator::SKIP_DOTS));
    foreach ($it as $f) {
        if (!$f->isFile()) continue;
        $rel  = relativeTo($f->getPathname(), BACKUP);
        $dest = SRC . '/' . $rel;
        @mkdir(dirname($dest), 0775, true);
        if (copy($f->getPathname(), $dest)) $n++;
    }
    echo "Restored $n files from backup.\n";
}

function fmt(int $b): string {
    return $b >= 1048576 ? sprintf('%.1f MB', $b / 1048576) : sprintf('%d KB', (int) round($b / 1024));
}

function trim52(string $s): string {
    return strlen($s) <= 52 ? $s : '...' . substr($s, -49);
}
