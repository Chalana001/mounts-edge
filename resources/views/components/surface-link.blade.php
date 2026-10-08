@props([
    'href',
    'surface' => 'light',
    'external' => false,
])

@php
    $class = $surface === 'dark'
        ? 'text-brand-cream/70 hover:text-brand-orange'
        : 'text-brand-green hover:text-brand-ember';
@endphp

<a href="{{ $href }}"
   @if ($external) target="_blank" rel="noopener noreferrer" @endif
   {{ $attributes->merge(['class' => 'underline transition-colors '.$class]) }}>
    {{ $slot }}
</a>
