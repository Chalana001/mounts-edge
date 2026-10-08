<section class="py-10 md:py-16 bg-brand-green">
    <div class="container mx-auto px-6">
        <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
            <x-cta-button href="tel:{{ $siteSettings->phone_link }}" data-conversion="contact_phone_click" variant="light" class="w-full sm:w-auto">
                Call Now
            </x-cta-button>

            <x-cta-button href="https://wa.me/{{ $siteSettings->whatsapp_number }}?text=Hello%20Mounts%20Edge%20Regency!%20I%20would%20like%20to%20make%20an%20inquiry." data-conversion="contact_whatsapp_click" variant="whatsapp" external class="w-full sm:w-auto">
                WhatsApp Us
            </x-cta-button>

            <x-cta-button href="mailto:{{ $siteSettings->public_email }}" data-conversion="contact_email_click" variant="outline-dark" class="w-full sm:w-auto">
                Email Us
            </x-cta-button>
        </div>
    </div>
</section>
