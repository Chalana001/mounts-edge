<section class="py-12 bg-brand-orange/5 border-y border-brand-orange/20 text-center"
         x-data="{ isVisible: false }"
         x-intersect.once.margin.-10%.0.-10%.0="isVisible = true">
    <div class="container mx-auto px-6">
        <div class="reveal-hidden" :class="isVisible ? 'reveal-visible' : ''">
            <h3 class="text-3xl md:text-4xl font-serif text-brand-green mb-6 leading-tight">Ready for Adventure?</h3>
            <p class="text-brand-green/70 mb-8 max-w-xl mx-auto font-light leading-relaxed">
                Stay at our <x-surface-link href="/luxury-stay">rooms in Gurulupotha</x-surface-link>, browse the <x-surface-link href="{{ route('gallery') }}">gallery</x-surface-link>, or send a Service Enquiry to arrange transport, tours, and day-outs around Hasalaka and Mahiyangana.
            </p>
            <x-cta-button href="{{ route('contact', ['type' => \App\Models\Enquiry::TYPE_SERVICE]) }}">
                Plan Your Excursion
            </x-cta-button>
        </div>
    </div>
</section>
