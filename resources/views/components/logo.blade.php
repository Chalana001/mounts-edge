@props([
    'variant' => 'full',
    'light' => false,
    'alt' => 'Mounts Edge Regency',
])

@php
    // 'light' swaps the dark-green ink for cream so the logo stays legible on brand-green.
    $file = match ($variant) {
        'mark' => 'logo-mark',
        'wordmark' => 'logo-wordmark',
        default => 'logo',
    } . ($light ? '-light' : '');
@endphp

{{-- No default sizing class: callers set their own, and a default w-auto would fight w-full. --}}
<img src="{{ asset('images/' . $file . '.svg') }}"
     alt="{{ $alt }}"
     {{ $attributes }}>
