@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-brand-green/30 focus:border-brand-green focus:ring-brand-green rounded-md shadow-sm']) !!}>
