@php
    // Where the map should centre. Business name first so Google drops the pin
    // on the property when it is listed, with the address as a fallback if it
    // cannot resolve the name.
    $mapQuery = trim('Mounts Edge Regency, '.$siteSettings->address, ', ');

    // Google's official Maps Embed API needs a key. Without one we fall back to
    // the keyless /maps?output=embed form: it 301s to /maps/embed, and that
    // final response carries no X-Frame-Options, so it frames fine.
    $mapsEmbedKey = config('services.google_maps.embed_key');

    $mapSrc = $mapsEmbedKey
        ? 'https://www.google.com/maps/embed/v1/place?key='.$mapsEmbedKey.'&q='.urlencode($mapQuery)
        : 'https://www.google.com/maps?q='.urlencode($mapQuery).'&z=15&hl=en&output=embed';
@endphp

<section class="relative h-[400px] md:h-[450px] bg-white border-t border-brand-green/10 overflow-hidden">
    <iframe
        src="{{ $mapSrc }}"
        class="absolute inset-0 w-full h-full border-0"
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"
        title="Map showing {{ $siteSettings->address }}">
    </iframe>
</section>
