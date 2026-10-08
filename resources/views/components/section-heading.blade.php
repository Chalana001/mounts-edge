@props([
    'eyebrow' => null,
    'title',
    'intro' => null,
    'surface' => 'light',
    'align' => 'center',
    'size' => 'standard',
])

@php
    $isDark = $surface === 'dark';
    $isLeft = $align === 'left';
    $titleClass = $size === 'large' ? 'text-4xl md:text-5xl' : 'text-3xl md:text-4xl';
@endphp

<div {{ $attributes->merge(['class' => 'mb-10 md:mb-14 '.($isLeft ? 'text-left' : 'text-center')]) }}>
    @if ($eyebrow)
        <span class="block mb-4 text-xs tracking-[0.3em] uppercase {{ $isDark ? 'text-brand-cream/70' : 'text-brand-green/70' }}">
            {{ $eyebrow }}
        </span>
    @endif

    <h2 class="font-serif {{ $titleClass }} {{ $isDark ? 'text-brand-light' : 'text-brand-green' }}">
        {{ $title }}
    </h2>

    @if ($intro)
        <p class="mt-4 max-w-2xl {{ $isLeft ? '' : 'mx-auto' }} text-sm md:text-base font-light leading-relaxed {{ $isDark ? 'text-brand-cream/70' : 'text-brand-green/70' }}">
            {{ $intro }}
        </p>
    @endif
</div>
