<section class="py-12 bg-brand-orange/5 border-y border-brand-orange/20" 
         x-data="{ isVisible: false }" 
         x-intersect.once.margin.-10%.0.-10%.0="isVisible = true">
    
    <div class="container mx-auto px-6">
        <div class="flex flex-col md:flex-row items-center justify-center gap-8 md:gap-12 reveal-hidden"
             :class="isVisible ? 'reveal-visible' : ''">
            
            <p class="text-brand-green/70 font-light text-sm md:text-base text-center max-w-xl">
                Seen something you like? Explore our <a href="{{ route('luxury-stay') }}" class="underline hover:text-brand-ember">rooms</a> and <a href="{{ route('experiences') }}" class="underline hover:text-brand-ember">nearby experiences</a>, or enquire directly.
            </p>

            <a href="{{ route('contact', ['type' => \App\Models\Enquiry::TYPE_ROOM]) }}"
                   class="bg-brand-green text-brand-light hover:bg-brand-hover transition-all duration-500 px-10 py-5 text-[11px] tracking-[0.2em] uppercase font-bold shadow-lg">
                Check Availability
            </a>
            
        </div>
    </div>
</section>