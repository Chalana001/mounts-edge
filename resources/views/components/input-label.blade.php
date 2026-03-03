@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-brand-green']) }}>
    {{ $value ?? $slot }}
</label>
