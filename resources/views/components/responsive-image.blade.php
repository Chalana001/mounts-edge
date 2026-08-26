@props([
    'src',
    // Variant widths to offer, e.g. [400, 800]. Only those that exist on disk
    // are used, so a missing variant degrades quietly rather than 404-ing.
    'widths' => [],
    'sizes' => null,
])

@php
    // Callers pass either a root-relative path or an asset() URL.
    $imgPath = parse_url($src, PHP_URL_PATH) ?: $src;
    $imgExt  = pathinfo($imgPath, PATHINFO_EXTENSION);
    $imgStem = substr($imgPath, 0, -(strlen($imgExt) + 1));

    // width => path, smallest first.
    $candidates = [];

    foreach ($widths as $w) {
        $variant = "{$imgStem}-{$w}w.{$imgExt}";
        if (is_file(public_path($variant))) {
            $candidates[$w] = $variant;
        }
    }

    $intrinsic = null;
    if (is_file(public_path($imgPath))) {
        $intrinsic = @getimagesize(public_path($imgPath)) ?: null;
        if ($intrinsic) {
            $candidates[$intrinsic[0]] = $imgPath;
        }
    }
    ksort($candidates);

    $rasterSet = [];
    $webpSet   = [];

    foreach ($candidates as $w => $path) {
        $rasterSet[] = asset(ltrim($path, '/'))." {$w}w";

        $webp = preg_replace('/\.[^.]+$/', '.webp', $path);
        if (is_file(public_path($webp))) {
            $webpSet[$w] = asset(ltrim($webp, '/'))." {$w}w";
        }
    }

    // A WebP <source> wins the negotiation outright, so the browser only ever
    // picks from what it offers -- which means partial coverage is worse than
    // none. A gap at the small end forces the browser up to the next width that
    // exists (a card wanting 800w was served a 1400w, nearly double the bytes);
    // a gap at the large end hands a wide viewport an undersized, blurry image.
    // So WebP is all-or-nothing per image: every candidate width must have one.
    $useWebp = $candidates !== [] && count($webpSet) === count($candidates);
@endphp

@if ($useWebp)
    {{-- display:contents so <picture> creates no box of its own -- the <img>
         keeps behaving exactly as it did before it was wrapped, which matters
         for the absolutely-positioned and h-full images this replaces. --}}
    <picture class="contents">
        <source type="image/webp"
                srcset="{{ implode(', ', $webpSet) }}"
                @if ($sizes) sizes="{{ $sizes }}" @endif>
        <img src="{{ $src }}"
             @if (count($rasterSet) > 1) srcset="{{ implode(', ', $rasterSet) }}" @endif
             @if ($sizes && count($rasterSet) > 1) sizes="{{ $sizes }}" @endif
             @if ($intrinsic && ! $attributes->has('width')) width="{{ $intrinsic[0] }}" height="{{ $intrinsic[1] }}" @endif
             {{ $attributes }}>
    </picture>
@else
    <img src="{{ $src }}"
         @if (count($rasterSet) > 1) srcset="{{ implode(', ', $rasterSet) }}" @endif
         @if ($sizes && count($rasterSet) > 1) sizes="{{ $sizes }}" @endif
         @if ($intrinsic && ! $attributes->has('width')) width="{{ $intrinsic[0] }}" height="{{ $intrinsic[1] }}" @endif
         {{ $attributes }}>
@endif
