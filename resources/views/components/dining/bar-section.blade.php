<section class="relative h-[60vh] overflow-hidden" 
         x-data="{ isVisible: false }" 
         x-intersect.once.margin.-25%.0.-25%.0="isVisible = true">
    
    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('storage/dining/bar.jfif');"></div>
    <div class="absolute inset-0 bg-brand-green/70"></div>

    <div class="relative z-10 h-full flex flex-col items-center justify-center text-center px-4 reveal-hidden"
         :class="isVisible ? 'reveal-visible' : ''">
        <span class="text-brand-orange text-xs tracking-[0.4em] uppercase mb-6 font-bold">The Terrace Bar</span>
        <h2 class="text-4xl md:text-5xl font-serif text-brand-light mb-6">Evening Ambiance</h2>
        <p class="text-[#F5F5DC]/70 text-lg max-w-xl font-light italic">
            "Unwind with handcrafted cocktails and premium spirits as you watch the sunset paint the mountains"
        </p>
    </div>
</section>