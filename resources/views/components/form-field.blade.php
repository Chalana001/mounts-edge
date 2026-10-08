@props([
    'label',
    'name',
    'type' => 'text',
    'value' => null,
    'error' => [],
    'required' => false,
    'options' => null,
    'rows' => null,
    'inputmode' => null,
    'autocomplete' => null,
    'placeholder' => null,
    'min' => null,
    'max' => null,
])

@php
    $fieldClass = 'w-full bg-brand-light border border-brand-green/30 p-4 text-sm font-light focus:border-brand-orange focus:ring-0 transition-all outline-none';
@endphp

<div class="space-y-1.5">
    <label for="{{ $name }}" class="text-[11px] font-bold uppercase tracking-widest text-brand-green">
        {{ $label }}{{ $required ? ' *' : '' }}
    </label>

    @if ($options !== null)
        <select id="{{ $name }}" name="{{ $name }}" {{ $required ? 'required' : '' }} {{ $attributes->merge(['class' => $fieldClass]) }}>
            {{ $slot }}
            @foreach ($options as $optionValue => $optionLabel)
                <option value="{{ $optionValue }}" @selected((string) $value === (string) $optionValue)>{{ $optionLabel }}</option>
            @endforeach
        </select>
    @elseif ($rows)
        <textarea id="{{ $name }}" name="{{ $name }}" rows="{{ $rows }}" {{ $required ? 'required' : '' }} @if($placeholder) placeholder="{{ $placeholder }}" @endif {{ $attributes->merge(['class' => $fieldClass]) }}>{{ $value }}</textarea>
    @else
        <input id="{{ $name }}" type="{{ $type }}" name="{{ $name }}" value="{{ $value }}" {{ $required ? 'required' : '' }} @if($inputmode) inputmode="{{ $inputmode }}" @endif @if($autocomplete) autocomplete="{{ $autocomplete }}" @endif @if($placeholder) placeholder="{{ $placeholder }}" @endif @if($min !== null) min="{{ $min }}" @endif @if($max !== null) max="{{ $max }}" @endif {{ $attributes->merge(['class' => $fieldClass]) }}>
    @endif

    <x-input-error :messages="$error" />
</div>
