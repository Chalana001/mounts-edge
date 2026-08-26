<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Mounts Edge Regency</title>

        @php
            $metaDescription = 'A semi-luxury retreat in Gurulupotha, Mahiyangana, for quiet stays and celebrations alike.';
        @endphp

        <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="32x32">
        <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
        <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">

        <meta name="description" content="{{ $metaDescription }}">
        <meta property="og:type" content="website">
        <meta property="og:site_name" content="Mounts Edge Regency">
        <meta property="og:title" content="Mounts Edge Regency">
        <meta property="og:description" content="{{ $metaDescription }}">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:image" content="{{ asset('images/og-image.jpg') }}">
        <meta property="og:image:width" content="1200">
        <meta property="og:image:height" content="630">
        <meta name="twitter:card" content="summary_large_image">

        {{-- The home hero's first background is applied by Alpine after the JS
             parses and runs, so the preload scanner never sees it and the LCP
             image starts downloading far later than it could. Declaring it here
             lets the fetch start with the HTML. Only on the home page: nowhere
             else uses this image, and preloading an unused asset costs more than
             it saves. --}}
        @if (request()->is('/'))
            <link rel="preload" as="image" href="{{ asset('storage/home/hero/mounts-edge-regency.jpg') }}" fetchpriority="high">
        @endif

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
        

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-brand-green bg-brand-light">
        {{-- Keyboard users would otherwise tab through all seven nav items on every page. --}}
        <a href="#main-content"
           class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-[70] focus:bg-brand-green focus:px-6 focus:py-3 focus:text-[11px] focus:font-bold focus:uppercase focus:tracking-[0.2em] focus:text-brand-light">
            Skip to content
        </a>

        <x-navbar />

        <main id="main-content">
            {{ $slot ?? '' }}
            @yield('content')
        </main>

        <x-footer />
        <x-floating-actions />
    </body>
</html>