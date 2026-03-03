<section class="py-12 bg-brand-orange/5 border-y border-brand-orange/20" 
         x-data="{ isVisible: false }" 
         x-intersect.once.margin.-10%.0.-10%.0="isVisible = true">
    
    <div class="container mx-auto px-6">
        <div class="flex flex-col md:flex-row items-center justify-center gap-8 md:gap-12 reveal-hidden"
             :class="isVisible ? 'reveal-visible' : ''">
            
            <p class="text-brand-green font-serif text-xl md:text-2xl text-center">
                Ready to begin your journey?
            </p>

            <div class="flex gap-4">
                <a href="/contact" 
                   class="bg-brand-green text-brand-light hover:bg-brand-orange transition-all duration-500 px-10 py-5 text-[10px] tracking-[0.2em] uppercase font-bold shadow-lg">
                    Check Availability
                </a>
            </div>
            
        </div>
    </div>
</section>