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
                Get in touch and we'll help you plan your stay in Mahiyangana.
            </p>

            <div class="flex flex-col sm:flex-row gap-6 justify-center">
                <a href="/luxury-stay" 
                   class="bg-transparent border border-brand-cream/40 text-brand-cream hover:bg-brand-cream hover:text-brand-green transition-all duration-500 px-12 py-5 text-[11px] tracking-[0.2em] uppercase font-bold rounded-none">
                    Stay
                </a>
                
                <a href="/weddings" 
                   class="bg-brand-cream text-brand-green hover:bg-brand-green hover:text-brand-light transition-all duration-500 px-12 py-5 text-[11px] tracking-[0.2em] uppercase font-bold rounded-none shadow-xl">
                    Celebrate
                </a>
            </div>
        </div>
    </div>
</section>