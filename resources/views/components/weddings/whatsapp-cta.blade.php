<section class="bg-brand-orange/10 py-16">
    <div class="container mx-auto px-6 text-center">
        <div class="flex flex-col md:flex-row items-center justify-center gap-8">
            <div class="text-left">
                <h3 class="text-2xl md:text-3xl font-serif text-brand-green mb-2">Ready to Plan Your Wedding?</h3>
                <p class="text-brand-green/70 font-light">Chat with our events team on WhatsApp, or see our <x-surface-link href="{{ route('dining') }}">dining</x-surface-link> and <x-surface-link href="{{ route('gallery') }}">gallery</x-surface-link></p>
            </div>

            <div class="flex flex-wrap items-center justify-center gap-3">
                <x-cta-button href="{{ route('contact', ['type' => \App\Models\Enquiry::TYPE_WEDDING]) }}">
                    Send an Enquiry
                </x-cta-button>

                <x-cta-button href="https://wa.me/{{ $siteSettings->whatsapp_number }}?text=Hello%20Mounts%20Edge%20Regency!%20I%20would%20like%20to%20plan%20my%20wedding." variant="whatsapp" external>
                    WhatsApp Us
                </x-cta-button>
            </div>
        </div>
    </div>
</section>
