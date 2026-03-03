<section class="relative py-32 md:py-40 overflow-hidden" 
         x-data="{ isVisible: false }" 
         x-intersect.once.margin.-15%.0.-15%.0="isVisible = true">
    
    <div class="absolute inset-0">
        <div class="absolute inset-0 bg-cover bg-center transition-transform duration-[10s] ease-in-out scale-110"
             :class="isVisible ? 'scale-100' : 'scale-110'"
             style="background-image: url('https://images.unsplash.com/photo-1470252649378-9c29740c9fa8?w=1920&q=80');">
        </div>
        <div class="absolute inset-0 bg-brand-green/70"></div>
    </div>

    <div class="relative z-10 container mx-auto px-6 text-center">
        <div class="max-w-2xl mx-auto reveal-hidden"
             :class="isVisible ? 'reveal-visible' : ''"
             style="transition-duration: 1.5s;">
            
            <span class="text-[#F5F5DC]/70 text-[10px] tracking-[0.4em] uppercase font-bold block mb-8">
                Your Journey Awaits
            </span>

            <h2 class="text-3xl md:text-5xl lg:text-6xl font-serif text-brand-light font-normal mb-8 leading-tight">
                Stay. Celebrate. Remember.
            </h2>

            <p class="text-[#F5F5DC]/70 text-base md:text-lg font-light mb-12 max-w-md mx-auto">
                Let us create memories that last a lifetime in the heart of Mahiyangana.
            </p>

            <div class="flex flex-col sm:flex-row gap-6 justify-center">
                <a href="/luxury-stay" 
                   class="bg-transparent border border-[#F5F5DC]/40 text-[#F5F5DC] hover:bg-[#F5F5DC] hover:text-brand-green transition-all duration-500 px-12 py-5 text-[10px] tracking-[0.2em] uppercase font-bold rounded-none">
                    Stay
                </a>
                
                <a href="/weddings" 
                   class="bg-[#F5F5DC] text-brand-green hover:bg-brand-orange hover:text-brand-light transition-all duration-500 px-12 py-5 text-[10px] tracking-[0.2em] uppercase font-bold rounded-none shadow-xl">
                    Celebrate
                </a>
            </div>
        </div>
    </div>
</section>