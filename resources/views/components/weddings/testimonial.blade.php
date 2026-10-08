@props([
    'quote' => 'Our wedding at Mounts Edge was absolutely magical. The mountain views, the incredible food, and the attention to detail made it unforgettable.',
    'author' => 'Sarah & James, 2024',
    'location' => 'Mahiyangana Highlands',
])

<section class="py-12 md:py-20 bg-brand-green overflow-hidden"
         x-data="{ isVisible: false }"
         x-intersect.once.margin.-25%.0.-25%.0="isVisible = true">

    <div class="container mx-auto px-6">
        <div class="max-w-4xl mx-auto text-center">

            <div class="reveal-hidden transition-all duration-[1500ms]"
                 :class="isVisible ? 'reveal-visible' : ''">

                <div class="mb-12 flex justify-center">
                    <svg class="w-12 h-12 text-brand-orange/30" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                    </svg>
                </div>

                <blockquote class="text-xl md:text-3xl font-serif text-brand-cream mb-12 leading-[1.35] font-light italic">
                    "{{ $quote }}"
                </blockquote>

                <div class="flex items-center justify-center gap-6">
                    <div class="h-px w-10 bg-brand-orange/40" aria-hidden="true"></div>
                    <p class="text-[11px] md:text-xs tracking-[0.4em] uppercase text-brand-cream/70 font-bold">
                        {{ $author }}
                    </p>
                    <div class="h-px w-10 bg-brand-orange/40" aria-hidden="true"></div>
                </div>

                <span class="mt-8 block text-[11px] tracking-[0.2em] uppercase text-brand-cream font-light">
                    {{ $location }}
                </span>

            </div>
        </div>
    </div>
</section>
