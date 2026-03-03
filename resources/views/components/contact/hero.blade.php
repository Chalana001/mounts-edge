<section class="relative h-[60vh] md:h-[70vh] flex items-center justify-center overflow-hidden" 
         x-data="{ isVisible: false }" 
         x-init="setTimeout(() => isVisible = true, 100)">
    
    <div class="absolute inset-0 bg-cover bg-center transition-transform duration-[10s] ease-out scale-110"
         :class="isVisible ? 'scale-100' : 'scale-110'"
         style="background-image: url('https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1920&q=80');">
    </div>
    <div class="absolute inset-0 bg-brand-green/40"></div>

    <div class="relative z-10 text-center px-4 pt-20">
        <div class="reveal-hidden transition-all duration-1000 delay-300"
             :class="isVisible ? 'reveal-visible' : ''">
            <span class="text-[#F5F5DC]/80 text-xs tracking-[0.3em] uppercase mb-6 block font-bold">
                Get In Touch
            </span>
            <h1 class="text-5xl md:text-7xl font-serif text-brand-light mb-6">Contact Us</h1>
            <div class="w-12 h-px bg-white/40 mx-auto mb-6"></div>
            <p class="text-[#F5F5DC]/80 text-lg md:text-xl max-w-xl font-light mx-auto italic">
                We'd love to hear from you
            </p>
        </div>
    </div>
</section>