<section class="relative h-[60vh] overflow-hidden"
         x-data="{ isVisible: false }" 
         x-intersect.once.margin.-25%.0.-25%.0="isVisible = true">
    
    <x-responsive-image :src="asset('storage/home/hero/pool4.jpg')"
                        :widths="[400, 1000]"
                        sizes="100vw"
                        alt=""
                        aria-hidden="true"
                        loading="lazy" decoding="async"
                        class="absolute inset-0 w-full h-full object-cover" />
    <div class="absolute inset-0 bg-brand-green/50"></div>

    <div class="relative z-10 h-full flex flex-col items-center justify-center text-center px-4 reveal-hidden"
         :class="isVisible ? 'reveal-visible' : ''">
        
        <span class="text-brand-cream/80 text-xs tracking-[0.3em] uppercase mb-6">Unwind & Refresh</span>
        <h2 class="text-4xl md:text-5xl font-serif text-brand-light mb-6">Pool & Relaxation</h2>
        <p class="text-brand-cream/70 text-lg max-w-xl font-light">
            Our infinity pool overlooks the mountain range. A quiet spot to relax any time of day.
        </p>
    </div>
</section>