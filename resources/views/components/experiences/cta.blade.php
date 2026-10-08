<section class="py-12 bg-brand-orange/5 border-y border-brand-orange/20 text-center"
         x-data="{ isVisible: false }"
         x-intersect.once.margin.-10%.0.-10%.0="isVisible = true">
    <div class="container mx-auto px-6">
        <div class="reveal-hidden" :class="isVisible ? 'reveal-visible' : ''">
            <h3 class="text-3xl md:text-4xl font-serif text-brand-green mb-6 leading-tight">Ready for Adventure?</h3>
            <p class="text-brand-green/70 mb-8 max-w-xl mx-auto font-light leading-relaxed">
                Stay at our <x-surface-link href="/luxury-stay">rooms in Gurulupotha</x-surface-link> and ask the team for directions, timing, and day-out help around Hasalaka and Mahiyangana. Photos of the area are in our <x-surface-link href="{{ route('gallery') }}">gallery</x-surface-link>.
            </p>
            <x-cta-button href="/contact">
                Plan Your Excursion
            </x-cta-button>
        </div>
    </div>
</section>
