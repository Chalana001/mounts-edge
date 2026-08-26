<section class="relative h-[60vh] overflow-hidden" 
         x-data="{ isVisible: false }" 
         x-intersect.once.margin.-25%.0.-25%.0="isVisible = true">
    
    {{-- Mid-page band under a 70% overlay: safe to defer. Also switched to
         asset() -- the bare 'storage/...' url() resolved relative to the current
         document, so it would have broken on any nested route. --}}
    <x-responsive-image :src="asset('storage/dining/bar.jfif')"
                        alt=""
                        aria-hidden="true"
                        loading="lazy" decoding="async"
                        class="absolute inset-0 w-full h-full object-cover" />
    <div class="absolute inset-0 bg-brand-green/70"></div>

    <div class="relative z-10 h-full flex flex-col items-center justify-center text-center px-4 reveal-hidden"
         :class="isVisible ? 'reveal-visible' : ''">
        <span class="text-brand-cream text-xs tracking-[0.4em] uppercase mb-6 font-bold">The Terrace Bar</span>
        <h2 class="text-4xl md:text-5xl font-serif text-brand-light mb-6">Evening Ambiance</h2>
        <p class="text-brand-cream/70 text-lg max-w-xl font-light italic">
            "Unwind with handcrafted cocktails and premium spirits as you watch the sunset paint the mountains"
        </p>
    </div>
</section>