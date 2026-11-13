<section class="py-12 bg-brand-orange/5 border-y border-brand-orange/20 text-center">
    <div class="container mx-auto px-6">
        <h3 class="text-3xl md:text-4xl font-serif text-brand-green mb-4">Ready to Book Your Stay?</h3>
        <p class="text-brand-green/70 mb-8 max-w-xl mx-auto font-light">
            Send an enquiry for Deluxe rooms or the Family Suite in Gurulupotha, call <x-surface-link href="tel:{{ $siteSettings->phone_link }}">{{ $siteSettings->phone_display }}</x-surface-link> or message us below. See also our <x-surface-link href="{{ route('weddings') }}">wedding venue</x-surface-link> and <x-surface-link href="{{ route('dining') }}">dining</x-surface-link>.
        </p>

        <div class="flex flex-wrap items-center justify-center gap-3">
            <x-cta-button href="{{ route('contact', ['type' => \App\Models\Enquiry::TYPE_ROOM]) }}">
                Book Now
            </x-cta-button>
            <x-cta-button href="https://wa.me/{{ $siteSettings->whatsapp_number }}?text=Hello%20Mounts%20Edge%20Regency!%20I%20would%20like%20to%20book%20a%20room." variant="whatsapp" external>
                WhatsApp Us
            </x-cta-button>
        </div>
    </div>
</section>
