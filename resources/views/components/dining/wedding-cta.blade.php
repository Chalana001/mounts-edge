{{-- Light band, matching <x-cta-strip> -- see rooms/booking-cta for why. --}}
<section class="py-12 bg-brand-orange/5 border-y border-brand-orange/20"
         x-data="{ isVisible: false }"
         x-intersect.once.margin.-10%.0.-10%.0="isVisible = true">
    <div class="container mx-auto px-6 text-center">
        <div class="reveal-hidden" :class="isVisible ? 'reveal-visible' : ''">
            <span class="text-brand-green/70 text-xs tracking-[0.3em] uppercase mb-4 block">Special Events</span>
            <h2 class="text-3xl md:text-4xl font-serif text-brand-green mb-6">Wedding &amp; Event Catering</h2>
            <p class="text-brand-green/70 max-w-xl mx-auto mb-8 font-light leading-relaxed">
                Our kitchen plans menus with you for weddings and celebrations in Mahiyangana, and outside caterers are welcome if you prefer your own.
            </p>
            <a href="/weddings"
               class="inline-block bg-brand-green text-brand-light hover:bg-brand-hover px-12 py-5 text-[11px] tracking-[0.2em] uppercase font-bold transition-all duration-500 shadow-lg">
                View Wedding Spaces
            </a>
        </div>
    </div>
</section>
