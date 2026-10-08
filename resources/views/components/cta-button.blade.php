@props([
    'href' => null,
    'variant' => 'primary',
    'external' => false,
    'type' => 'button',
])

@php
    $base = 'inline-flex min-h-12 items-center justify-center rounded-none px-8 py-4 text-[11px] tracking-[0.2em] uppercase font-bold transition-colors duration-500 focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-orange focus-visible:ring-offset-2';

    $variants = [
        'primary' => 'bg-brand-green text-brand-light hover:bg-brand-hover',
        'secondary' => 'border border-brand-green/30 text-brand-green hover:border-brand-ember hover:text-brand-ember',
        'light' => 'bg-brand-light text-brand-green hover:bg-brand-cream',
        'outline-dark' => 'border border-brand-cream/60 text-brand-light hover:border-brand-orange hover:text-brand-orange',
        'whatsapp' => 'bg-whatsapp text-white hover:bg-whatsapp-dark',
    ];

    $class = trim($base.' '.($variants[$variant] ?? $variants['primary']));
@endphp

@if ($href)
    <a href="{{ $href }}"
       @if ($external) target="_blank" rel="noopener noreferrer" @endif
       {{ $attributes->merge(['class' => $class]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $class]) }}>
        {{ $slot }}
    </button>
@endif
