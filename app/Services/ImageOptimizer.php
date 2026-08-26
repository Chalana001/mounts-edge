<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * Resizes and re-encodes uploaded images before they are served.
 *
 * Without this, every admin upload lands on disk exactly as it came off the
 * camera -- which is how the library reached 61 MB with individual files over
 * 4 MB. Optimising the existing files was a one-time cleanup; this is what stops
 * it happening again.
 *
 * Built on ext-gd, which this app already requires, rather than pulling in an
 * imaging package: the failure mode of a missing dependency on the server is far
 * worse than the small amount of code below.
 */
class ImageOptimizer
{
    /**
     * Longest-edge cap per storage folder, matched by prefix.
     * Mirrors scripts/optimize-images.php so a re-upload matches the library.
     */
    protected const CAPS = [
        'gallery'     => 1500,
        'weddings'    => 1500,
        'rooms'       => 1400,
        'dining'      => 1400,
        'experiences' => 1200,
    ];

    protected const DEFAULT_CAP = 1400;

    /**
     * Extra widths to emit as <name>-<width>w.<ext> siblings.
     *
     * Only the gallery is listed, because the gallery grid is the one template
     * that builds a srcset from uploaded images (it probes for these widths).
     * Room and hall images render through <x-image-slider>, which has no srcset,
     * so generating variants for them would only produce files nothing requests.
     * Add a folder here at the same time as the srcset that consumes it.
     */
    protected const VARIANTS = [
        'gallery' => [400, 800],
    ];

    protected const QUALITY = 78;

    /**
     * Above this, a file is assumed to still be a raw original worth
     * re-encoding. A quality-78 photo lands around 0.08-0.15 bytes per pixel;
     * the 4 MB camera originals this app started with were nearer 1.0.
     */
    protected const LEAN_BYTES_PER_PIXEL = 0.18;

    /**
     * A .webp sibling is only kept when it beats the original by at least this
     * much. Against already-optimised JPEGs, WebP's win ranges from about 4% to
     * 41% depending on the image, and a 4% saving is not worth a second file on
     * disk, a second cache entry, and an extra <source> for the browser to
     * evaluate. Below this threshold the JPEG is simply served to everyone.
     */
    protected const WEBP_MIN_SAVING = 0.10;

    /**
     * Store an upload, then optimise it and emit its variants.
     *
     * Returns the disk-relative path (e.g. "gallery/abc123.jpg"), matching what
     * UploadedFile::store() returns, so call sites keep their existing
     * "/storage/{$path}" convention.
     */
    public function store(UploadedFile $file, string $folder, string $disk = 'public'): string
    {
        $path = $file->store($folder, $disk);

        // A failure here must never lose the upload: the unoptimised file is
        // already safely stored, so log and carry on rather than throwing.
        try {
            $absolute = Storage::disk($disk)->path($path);
            $this->optimize($absolute, $this->capFor($folder));
            $this->makeVariants($absolute, $this->variantsFor($folder));
            // After the variants, so each one gets a matching .webp too.
            $this->makeWebp($absolute);
        } catch (\Throwable $e) {
            Log::warning('Image optimisation failed, serving original.', [
                'path' => $path,
                'error' => $e->getMessage(),
            ]);
        }

        return $path;
    }

    /**
     * Re-encode in place, capped to $maxEdge. Returns the new size in bytes, or
     * null if the file was left untouched.
     */
    public function optimize(string $absolute, int $maxEdge): ?int
    {
        $info = @getimagesize($absolute);
        if ($info === false) {
            return null;
        }

        [$w, $h, $type] = $info;
        $image = $this->read($absolute, $type);
        if (!$image) {
            return null;
        }

        // Phones write the sensor orientation to EXIF rather than rotating the
        // pixels. GD discards EXIF on write, so without this an upload taken in
        // portrait would come back rotated.
        $orientation = $this->orientation($absolute, $type);
        $image = $this->applyOrientation($image, $orientation);
        $w = imagesx($image);
        $h = imagesy($image);

        $scale = min(1.0, $maxEdge / max($w, $h));
        $newW = max(1, (int) round($w * $scale));
        $newH = max(1, (int) round($h * $scale));

        $before = filesize($absolute);
        $needsResize = ($newW !== $w || $newH !== $h);
        $needsRotate = $orientation > 1;

        // Bail out before touching the pixels when there is nothing to gain.
        // Re-encoding an already-lean JPEG shaves a few bytes but compounds
        // compression artefacts every time, so a repeat run must be a genuine
        // no-op rather than a slow quality leak. Bytes-per-pixel is the cheap
        // proxy for "has already been through a quality pass".
        if (!$needsResize && !$needsRotate && ($before / max(1, $w * $h)) <= self::LEAN_BYTES_PER_PIXEL) {
            imagedestroy($image);

            return null;
        }

        if ($needsResize) {
            $image = $this->resample($image, $w, $h, $newW, $newH, $type);
        }

        $temp = $absolute . '.opt';

        if (!$this->write($image, $temp, $type)) {
            imagedestroy($image);
            @unlink($temp);
            return null;
        }
        imagedestroy($image);

        clearstatcache(true, $temp);
        $after = filesize($temp);

        // Never write a bigger file. This has to hold whether or not the image
        // was resized -- a well-encoded original can re-encode larger even after
        // being scaled down. Rotation is the one case worth accepting a larger
        // file for, since a wrongly-oriented image is broken at any size.
        if ($after >= $before && !$needsRotate) {
            @unlink($temp);
            return null;
        }

        rename($temp, $absolute);
        clearstatcache(true, $absolute);

        return $after;
    }

    /**
     * Emit downscaled siblings. Widths at or above the source are skipped rather
     * than upscaled, and a variant that saves nothing is discarded.
     *
     * @param  array<int, int>  $widths
     * @return array<int, string>  absolute paths written
     */
    public function makeVariants(string $absolute, array $widths): array
    {
        $info = @getimagesize($absolute);
        if ($info === false || !$widths) {
            return [];
        }

        [$w, $h, $type] = $info;
        $written = [];

        foreach ($widths as $target) {
            if ($target >= $w) {
                continue;
            }

            $source = $this->read($absolute, $type);
            if (!$source) {
                continue;
            }

            $targetH = max(1, (int) round($h * ($target / $w)));
            $resized = $this->resample($source, $w, $h, $target, $targetH, $type);

            $variant = $this->variantPath($absolute, $target);
            $ok = $this->write($resized, $variant, $type);
            imagedestroy($resized);

            if (!$ok) {
                continue;
            }

            clearstatcache(true, $variant);
            if (filesize($variant) >= filesize($absolute)) {
                @unlink($variant);
                continue;
            }

            $written[] = $variant;
        }

        return $written;
    }

    /**
     * Write a .webp sibling next to $absolute, plus one for each of its
     * -<width>w variants, so a <picture> can offer a matching WebP srcset.
     *
     * Returns the paths written. A file that is already WebP is skipped, as is
     * one where the conversion does not clear WEBP_MIN_SAVING.
     *
     * @return array<int, string>
     */
    public function makeWebp(string $absolute): array
    {
        // The threshold is judged once, on the full-size image, and then applied
        // to the whole group.
        //
        // Deciding per file instead would leave partial coverage, and partial
        // coverage is actively harmful: a <picture> source wins the negotiation
        // outright, so if the width the layout actually wants has no WebP, the
        // browser is forced up to the next size that does. That happened here --
        // a card needing an 800w (109 KB) was served a 1400w WebP (215 KB),
        // worse than serving no WebP at all.
        $full = $this->convertToWebp($absolute);

        if ($full === null) {
            return [];
        }

        if ($full['size'] > $full['source'] * (1 - self::WEBP_MIN_SAVING)) {
            @unlink($full['path']);

            return [];
        }

        $written = [$full['path']];

        foreach ($this->siblingVariants($absolute) as $variant) {
            $result = $this->convertToWebp($variant);

            if ($result === null) {
                continue;
            }

            // Variants only need to beat their own raster file, not the 10%
            // threshold -- they exist to complete the set. One that comes out
            // larger is dropped, and the component then falls back to raster
            // for the whole image rather than serving a mixed set.
            if ($result['size'] >= $result['source']) {
                @unlink($result['path']);

                continue;
            }

            $written[] = $result['path'];
        }

        return $written;
    }

    /**
     * Encode one file to a .webp sibling.
     *
     * @return array{path: string, size: int, source: int}|null
     */
    protected function convertToWebp(string $source): ?array
    {
        $path = $this->webpPath($source);

        if ($path === null) {
            return null;
        }

        if (is_file($path)) {
            return ['path' => $path, 'size' => filesize($path), 'source' => filesize($source)];
        }

        $info = @getimagesize($source);
        if ($info === false) {
            return null;
        }

        $image = $this->read($source, $info[2]);
        if (!$image) {
            return null;
        }

        $ok = imagewebp($image, $path, self::QUALITY);
        imagedestroy($image);

        if (!$ok) {
            @unlink($path);

            return null;
        }

        clearstatcache(true, $path);

        return ['path' => $path, 'size' => filesize($path), 'source' => filesize($source)];
    }

    /**
     * The .webp path for a source, or null when the source is already WebP.
     */
    public function webpPath(string $absolute): ?string
    {
        $ext = pathinfo($absolute, PATHINFO_EXTENSION);

        if (strtolower($ext) === 'webp') {
            return null;
        }

        return substr($absolute, 0, -(strlen($ext) + 1)) . '.webp';
    }

    /**
     * The -<width>w variants sitting beside a source image.
     *
     * @return array<int, string>
     */
    public function siblingVariants(string $absolute): array
    {
        $ext = pathinfo($absolute, PATHINFO_EXTENSION);
        $stem = substr($absolute, 0, -(strlen($ext) + 1));

        return array_values(array_filter(
            glob("{$stem}-*w.{$ext}") ?: [],
            fn ($p) => (bool) preg_match('/-\d+w\.[^.]+$/', $p)
        ));
    }

    /**
     * Delete an image and any variants generated alongside it. Call sites that
     * replace or remove an image must use this, or the variants outlive the
     * original and the srcset keeps pointing at a stale photo.
     */
    public function forget(string $absolute): void
    {
        // Globbed rather than derived from VARIANTS: variants generated under an
        // older width set, or by scripts/generate-variants.php, must still be
        // cleaned up when their original goes.
        $ext = pathinfo($absolute, PATHINFO_EXTENSION);
        $stem = substr($absolute, 0, -(strlen($ext) + 1));

        $doomed = array_merge(
            $this->siblingVariants($absolute),
            glob("{$stem}-*w.webp") ?: [],
            array_filter([$this->webpPath($absolute)])
        );

        foreach ($doomed as $path) {
            if (is_file($path)) {
                @unlink($path);
            }
        }
    }

    public function variantPath(string $absolute, int $width): string
    {
        $ext = pathinfo($absolute, PATHINFO_EXTENSION);
        $stem = substr($absolute, 0, -(strlen($ext) + 1));

        return "{$stem}-{$width}w.{$ext}";
    }

    protected function capFor(string $folder): int
    {
        $key = strtok(trim($folder, '/'), '/');

        return self::CAPS[$key] ?? self::DEFAULT_CAP;
    }

    protected function variantsFor(string $folder): array
    {
        $key = strtok(trim($folder, '/'), '/');

        return self::VARIANTS[$key] ?? [];
    }

    protected function read(string $path, int $type)
    {
        return match ($type) {
            IMAGETYPE_JPEG => @imagecreatefromjpeg($path),
            IMAGETYPE_PNG  => @imagecreatefrompng($path),
            IMAGETYPE_WEBP => @imagecreatefromwebp($path),
            default => false,
        };
    }

    protected function write($image, string $path, int $type): bool
    {
        return match ($type) {
            IMAGETYPE_JPEG => imageinterlace($image, true) && imagejpeg($image, $path, self::QUALITY),
            IMAGETYPE_PNG  => imagepng($image, $path, 9),
            IMAGETYPE_WEBP => imagewebp($image, $path, self::QUALITY),
            default => false,
        };
    }

    protected function resample($image, int $w, int $h, int $newW, int $newH, int $type)
    {
        $out = imagecreatetruecolor($newW, $newH);

        if ($type === IMAGETYPE_PNG || $type === IMAGETYPE_WEBP) {
            imagealphablending($out, false);
            imagesavealpha($out, true);
        }

        imagecopyresampled($out, $image, 0, 0, 0, 0, $newW, $newH, $w, $h);
        imagedestroy($image);

        return $out;
    }

    protected function applyOrientation($image, int $orientation)
    {
        // imagerotate() turns counter-clockwise, hence 270 for a 90-degree
        // clockwise correction.
        return match ($orientation) {
            2 => $this->flip($image, IMG_FLIP_HORIZONTAL),
            3 => imagerotate($image, 180, 0),
            4 => $this->flip($image, IMG_FLIP_VERTICAL),
            5 => $this->flip(imagerotate($image, 270, 0), IMG_FLIP_HORIZONTAL),
            6 => imagerotate($image, 270, 0),
            7 => $this->flip(imagerotate($image, 90, 0), IMG_FLIP_HORIZONTAL),
            8 => imagerotate($image, 90, 0),
            default => $image,
        };
    }

    protected function flip($image, int $mode)
    {
        imageflip($image, $mode);

        return $image;
    }

    /**
     * Reads the EXIF orientation tag straight out of the JPEG APP1 segment.
     *
     * ext-exif is not loaded in this environment, and the tag matters too much
     * to skip, so the segment is parsed directly. Returns 1 when absent.
     */
    protected function orientation(string $path, int $type): int
    {
        if ($type !== IMAGETYPE_JPEG) {
            return 1;
        }

        $handle = @fopen($path, 'rb');
        if (!$handle) {
            return 1;
        }
        $data = fread($handle, 131072);
        fclose($handle);

        if (substr($data, 0, 2) !== "\xFF\xD8") {
            return 1;
        }

        $i = 2;
        $n = strlen($data);

        while ($i < $n - 4) {
            if ($data[$i] !== "\xFF") {
                $i++;
                continue;
            }

            $marker = ord($data[$i + 1]);

            if ($marker === 0xD8 || $marker === 0x01 || ($marker >= 0xD0 && $marker <= 0xD7)) {
                $i += 2;
                continue;
            }
            if ($marker === 0xDA || $marker === 0xD9) {
                return 1;
            }

            $length = unpack('n', substr($data, $i + 2, 2))[1];

            if ($marker === 0xE1 && substr($data, $i + 4, 6) === "Exif\0\0") {
                return $this->orientationFromTiff($data, $i + 10, $n);
            }

            $i += 2 + $length;
        }

        return 1;
    }

    protected function orientationFromTiff(string $data, int $tiff, int $n): int
    {
        $byteOrder = substr($data, $tiff, 2);
        if ($byteOrder !== 'II' && $byteOrder !== 'MM') {
            return 1;
        }

        $little = ($byteOrder === 'II');
        $u32 = fn (int $o) => unpack($little ? 'V' : 'N', substr($data, $o, 4))[1];
        $u16 = fn (int $o) => unpack($little ? 'v' : 'n', substr($data, $o, 2))[1];

        $ifd = $tiff + $u32($tiff + 4);
        if ($ifd + 2 > $n) {
            return 1;
        }

        $count = $u16($ifd);
        for ($e = 0; $e < $count; $e++) {
            $entry = $ifd + 2 + $e * 12;
            if ($entry + 12 > $n) {
                return 1;
            }
            if ($u16($entry) === 0x0112) {
                $value = $u16($entry + 8);

                return ($value >= 1 && $value <= 8) ? $value : 1;
            }
        }

        return 1;
    }
}
