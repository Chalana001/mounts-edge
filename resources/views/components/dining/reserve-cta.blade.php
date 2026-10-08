<section class="bg-brand-green py-12 md:py-20 text-center"
         x-data="{ isVisible: false }"
         x-intersect.once.margin.-25%.0.-25%.0="isVisible = true">
    <div class="container mx-auto px-6 reveal-hidden" :class="isVisible ? 'reveal-visible' : ''">
        <h3 class="text-3xl md:text-4xl font-serif text-brand-light mb-4">Reserve Your Table</h3>
        <p class="text-brand-cream/70 mb-8 max-w-xl mx-auto font-light">
            Walk-ins are always welcome. Reserve ahead for larger groups and weekends and we'll have the table ready. Planning a celebration? See our <x-surface-link href="/weddings" surface="dark">wedding venue</x-surface-link>.
        </p>

        <div class="flex flex-wrap items-center justify-center gap-3">
            <x-cta-button href="{{ route('contact', ['type' => \App\Models\Enquiry::TYPE_DINING]) }}" variant="light">
                Reserve a Table
            </x-cta-button>

            <x-cta-button href="https://wa.me/{{ $siteSettings->whatsapp_number }}?text=Hello%20Mounts%20Edge%20Regency!%20I%20would%20like%20to%20reserve%20a%20table." variant="outline-dark" external>
                WhatsApp Us
            </x-cta-button>
        </div>
    </div>
</section>
