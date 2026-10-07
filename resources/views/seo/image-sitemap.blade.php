<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
@foreach ($images as $entry)
    <url>
        <loc>{{ $entry['page'] }}</loc>
        <image:image>
            <image:loc>{{ $entry['image'] }}</image:loc>
            <image:title>{{ $entry['title'] }}</image:title>
        </image:image>
    </url>
@endforeach
</urlset>
