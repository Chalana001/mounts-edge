<section class="relative py-12 md:py-20 overflow-hidden"
         x-data="{ isVisible: false }" 
         x-intersect.once.margin.-25%.0.-25%.0="isVisible = true">
    
    <div class="absolute inset-0">
        {{-- Last section on the page, and it sits under a 70% green overlay, so
             it is both the safest to defer and the cheapest to serve small. --}}
        <x-responsive-image :src="asset('storage/weddings/highlights/2.jpg')"
                            :widths="[400, 800]"
                            sizes="100vw"
                            alt=""
                            aria-hidden="true"
                            loading="lazy" decoding="async"
                            class="absolute inset-0 w-full h-full object-cover transition-transform duration-[10s] ease-in-out scale-110"
                            ::class="isVisible ? 'scale-100' : 'scale-110'" />
        <div class="absolute inset-0 bg-brand-green/70"></div>
    </div>

    <div class="relative z-10 container mx-auto px-6 text-center">
        <div class="max-w-2xl mx-auto reveal-hidden"
             :class="isVisible ? 'reveal-visible' : ''"
             style="transition-duration: 1.5s;">
            
            <span class="text-brand-cream/70 text-[11px] tracking-[0.4em] uppercase font-bold block mb-8">
                Plan Your Visit
            </span>

            <h2 class="text-3xl md:text-5xl lg:text-6xl font-serif text-brand-light font-normal mb-8 leading-tight">
                Stay. Celebrate. Remember.
            </h2>

            <p class="text-brand-cream/70 text-base md:text-lg font-light mb-12 max-w-md mx-auto">
                Get in touch and we'll help you plan your stay in Mahiyangana: <x-surface-link href="/luxury-stay" surface="dark">rooms</x-surface-link>, <x-surface-link href="/weddings" surface="dark">weddings</x-surface-link>, <x-surface-link href="/dining" surface="dark">dining</x-surface-link>, and <x-surface-link href="/experiences" surface="dark">day-outs</x-surface-link>.
            </p>

            <div class="flex flex-col sm:flex-row gap-6 justify-center">
                <x-cta-button href="/luxury-stay" variant="outline-dark">
                    Stay
                </x-cta-button>

                <x-cta-button href="/weddings" variant="light">
                    Celebrate
                </x-cta-button>
            </div>
        </div>
    </div>
</section>