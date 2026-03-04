<section class="py-24 md:py-32 bg-white overflow-hidden" 
         x-data="{ isVisible: false }" 
         x-intersect.once.margin.-25%.0.-25%.0="isVisible = true">
    
    <div class="container mx-auto px-6">
        <div class="grid md:grid-cols-2 gap-16 items-center max-w-6xl mx-auto">
            
            <div class="reveal-hidden" :class="isVisible ? 'reveal-visible' : ''">
                <span class="text-brand-green/70 text-xs tracking-[0.2em] uppercase mb-4 block">Restaurant</span>
                <h2 class="text-4xl md:text-5xl font-serif text-brand-green mb-6 leading-tight">Dine with a View</h2>
                <p class="text-brand-green/70 leading-relaxed mb-8 font-light text-lg">
                    Our main restaurant offers panoramic mountain views through floor-to-ceiling windows. 
                    From a hearty breakfast to a romantic candlelit dinner, every meal is a celebration of Mahiyangana's natural beauty.
                </p>
                
                <div class="flex items-center gap-3 text-brand-green/70">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                    </svg>
                    <span class="text-xs tracking-widest uppercase font-bold">Open daily: 6:30 AM - 10:00 PM</span>
                </div>
            </div>

            <div class="reveal-hidden" :class="isVisible ? 'reveal-visible' : ''" style="transition-delay: 300ms;">
                <div class="aspect-[4/3] overflow-hidden shadow-2xl">
                    <img src="storage/dining/dining.jpg" 
                         class="w-full h-full object-cover transition-transform duration-[3000ms] hover:scale-105">
                </div>
            </div>

        </div>
    </div>
</section>