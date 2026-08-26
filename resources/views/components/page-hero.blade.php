@props([
    'image',
    'eyebrow',
    'title',
    'subtitle' => null,
    'quote' => false,
    'overlay' => 'bg-brand-green/40',
])

{{-- One hero for every inner page. Previously six near-copies of this markup drifted
     apart: three different ways of centring, two different overlay colours, and only
     Contact carried the navbar offset -- so the title landed at a different height on
     almost every page. --}}
<section class="relative h-[70vh] md:h-[80vh] overflow-hidden"
         x-data="{ shown: false }"
         x-init="setTimeout(() => shown = true, 100)">

    {{-- This is the LCP element on every inner page, so it stays eager and gets
         fetchpriority. As a CSS background it was invisible to the preload
         scanner until the stylesheet resolved.

         The width list spans every size any caller's image might have, since
         these heroes are drawn from two different folders; only the variants
         that exist on disk are offered. --}}
    <x-responsive-image :src="$image"
                        :widths="[400, 600, 800, 1000, 1200, 1400]"
                        sizes="100vw"
                        alt=""
                        aria-hidden="true"
                        fetchpriority="high"
                        decoding="async"
                        class="absolute inset-0 w-full h-full object-cover transition-transform duration-[10s] ease-out scale-110"
                        ::class="shown ? 'scale-100' : 'scale-110'" />
    <div class="absolute inset-0 {{ $overlay }}"></div>

    {{-- pt-20 offsets the fixed navbar. Centring in the full section height puts the
         block visually high in the space the visitor can actually see. --}}
    <div class="relative z-10 h-full flex flex-col items-center justify-center text-center px-6 pt-20">
        <div class="reveal-fade transition-all duration-1000 delay-300"
             :class="shown ? 'reveal-visible' : ''">

            <span class="block mb-6 text-xs font-bold uppercase tracking-[0.3em] text-brand-cream/80">
                {{ $eyebrow }}
            </span>

            <h1 class="mb-6 font-serif text-[clamp(2.5rem,7vw,4.5rem)] leading-[1.08] text-brand-light">
                {{ $title }}
            </h1>

            <div class="mx-auto mb-6 h-px w-12 bg-brand-orange/40"></div>

            @if($subtitle)
                <p @class([
                    'mx-auto max-w-xl text-[clamp(1rem,2vw,1.25rem)] font-light text-brand-cream/80',
                    'italic' => $quote,
                ])>
                    {{ $subtitle }}
                </p>
            @endif
        </div>
    </div>
</section>
