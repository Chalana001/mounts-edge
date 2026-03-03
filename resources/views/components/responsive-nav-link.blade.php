@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-brand-green text-start text-base font-medium text-brand-green bg-brand-green/5 focus:outline-none focus:text-brand-green focus:bg-brand-green/10 focus:border-brand-green transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-brand-green/70 hover:text-brand-green hover:bg-brand-green/5 hover:border-brand-green/30 focus:outline-none focus:text-brand-green focus:bg-brand-green/5 focus:border-brand-green/30 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
