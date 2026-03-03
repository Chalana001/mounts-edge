@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-brand-green text-sm font-medium leading-5 text-brand-green focus:outline-none focus:border-brand-green transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-brand-green/70 hover:text-brand-green hover:border-brand-green/30 focus:outline-none focus:text-brand-green focus:border-brand-green/30 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
