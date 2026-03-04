<section class="relative h-[60vh] overflow-hidden"
         x-data="{ isVisible: false }" 
         x-intersect.once.margin.-25%.0.-25%.0="isVisible = true">
    
    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1576013551627-0cc20b96c2a7?w=1920&q=80');"></div>
    <div class="absolute inset-0 bg-brand-green/50"></div>

    <div class="relative z-10 h-full flex flex-col items-center justify-center text-center px-4 reveal-hidden"
         :class="isVisible ? 'reveal-visible' : ''">
        
        <span class="text-[#F5F5DC]/80 text-xs tracking-[0.3em] uppercase mb-6">Unwind & Refresh</span>
        <h2 class="text-4xl md:text-5xl font-serif text-brand-light mb-6">Pool & Relaxation</h2>
        <p class="text-[#F5F5DC]/70 text-lg max-w-xl font-light">
            Our infinity pool overlooks the breathtaking mountain range, offering the perfect setting for relaxation.
        </p>
    </div>
</section>