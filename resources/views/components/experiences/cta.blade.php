{{-- Light band, matching <x-cta-strip> -- see rooms/booking-cta for why. --}}
<section class="py-12 bg-brand-orange/5 border-y border-brand-orange/20 text-center"
         x-data="{ isVisible: false }"
         x-intersect.once.margin.-10%.0.-10%.0="isVisible = true">
    <div class="container mx-auto px-6">
        <div class="reveal-hidden" :class="isVisible ? 'reveal-visible' : ''">
            <h3 class="text-3xl md:text-4xl font-serif text-brand-green mb-6 leading-tight">Ready for Adventure?</h3>
            <p class="text-brand-green/70 mb-8 max-w-xl mx-auto font-light leading-relaxed">
                Stay at our <a href="/luxury-stay" class="underline hover:text-brand-ember">rooms in Gurulupotha</a> and ask the team for directions, timing, and day-out help around Hasalaka and Mahiyangana. Photos of the area are in our <a href="{{ route('gallery') }}" class="underline hover:text-brand-ember">gallery</a>.
            </p>
            <a href="/contact"
               class="inline-block bg-brand-green text-brand-light hover:bg-brand-hover px-12 py-5 text-[11px] tracking-[0.2em] uppercase font-bold transition-all duration-500 shadow-lg">
                Plan Your Excursion
            </a>
        </div>
    </div>
</section>
