@props(['images' => [], 'alt' => '', 'interval' => 4000])

@php
    $images = array_values(array_filter((array) $images));
@endphp

@if (count($images) === 1)
    <img src="{{ $images[0] }}" alt="{{ $alt }}"
         class="w-full h-full object-cover transition-transform duration-[2000ms] group-hover:scale-110">
@elseif (count($images) > 1)
    <div x-data="imageSlider({{ count($images) }}, {{ (int) $interval }})"
         x-intersect="start()"
         x-intersect:leave="stop()"
         @mouseenter="stop()"
         @mouseleave="start()"
         class="absolute inset-0">

        @foreach ($images as $i => $image)
            <img src="{{ $image }}" alt="{{ $alt }}"
                 class="absolute inset-0 w-full h-full object-cover transition-all duration-1000 ease-in-out group-hover:scale-110"
                 :class="index === {{ $i }} ? 'opacity-100' : 'opacity-0'"
                 @if ($i > 0) loading="lazy" @endif>
        @endforeach

        {{-- Controls sit on the right; the tagline badge owns the bottom-left corner. --}}
        <div class="absolute top-3 right-3 z-20 flex gap-2">
            <button type="button" @click="prev()" aria-label="Previous image"
                    class="w-9 h-9 rounded-full border border-white/40 bg-black/25 backdrop-blur-sm flex items-center justify-center text-white hover:bg-white hover:text-black transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
            </button>
            <button type="button" @click="next()" aria-label="Next image"
                    class="w-9 h-9 rounded-full border border-white/40 bg-black/25 backdrop-blur-sm flex items-center justify-center text-white hover:bg-white hover:text-black transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            </button>
        </div>

        <div class="absolute bottom-3 right-3 z-20 flex gap-1.5">
            @foreach ($images as $i => $image)
                <button type="button" @click="go({{ $i }})" aria-label="Go to image {{ $i + 1 }}"
                        class="h-1.5 rounded-full transition-all duration-300"
                        :class="index === {{ $i }} ? 'w-5 bg-white' : 'w-1.5 bg-white/50 hover:bg-white/80'"></button>
            @endforeach
        </div>
    </div>
@endif
