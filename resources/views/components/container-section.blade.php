@props([
    'maxWidth' => null,
    'padding' => 'standard',
])

@php
    $widths = [
        'sm' => 'max-w-3xl',
        'md' => 'max-w-4xl',
        'lg' => 'max-w-5xl',
        'xl' => 'max-w-6xl',
    ];
    $vertical = $padding === 'compact' ? 'py-10 md:py-16' : 'py-12 md:py-20';
@endphp

<section {{ $attributes->merge(['class' => $vertical]) }}>
    <div class="container mx-auto px-6 {{ $widths[$maxWidth] ?? '' }}">
        {{ $slot }}
    </div>
</section>
