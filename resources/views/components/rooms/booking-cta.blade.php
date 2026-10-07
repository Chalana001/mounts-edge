{{-- Light band, matching <x-cta-strip> on the gallery page. This used to be
     bg-brand-green, which ran straight into the green footer with no edge between
     them; the pale ground plus border-y gives the footer something to start against. --}}
<section class="py-12 bg-brand-orange/5 border-y border-brand-orange/20 text-center"
         x-data="{ isVisible: false }"
         x-intersect.once.margin.-10%.0.-10%.0="isVisible = true">
    <div class="container mx-auto px-6">
        <div class="reveal-hidden" :class="isVisible ? 'reveal-visible' : ''">
            <h3 class="text-3xl md:text-4xl font-serif text-brand-green mb-4">Ready to Book Your Stay?</h3>
            <p class="text-brand-green/70 mb-8 max-w-xl mx-auto font-light">
                Send an enquiry for Deluxe and Family Suite rooms in Gurulupotha — call <a href="tel:{{ $siteSettings->phone_link }}" class="underline hover:text-brand-ember">{{ $siteSettings->phone_display }}</a> or message us below. See also our <a href="{{ route('weddings') }}" class="underline hover:text-brand-ember">wedding venue</a> and <a href="{{ route('dining') }}" class="underline hover:text-brand-ember">dining</a>.
            </p>

            <div class="flex flex-wrap items-center justify-center gap-3">
                <a href="{{ route('contact', ['type' => \App\Models\Enquiry::TYPE_ROOM]) }}"
                   class="bg-brand-green text-brand-light hover:bg-brand-hover px-12 py-5 text-[11px] tracking-[0.2em] uppercase font-bold transition-all duration-500 shadow-lg">
                    Book Now
                </a>

                {{-- brand-ember rather than brand-orange for the hover: on a light ground
                     brand-orange is only 2.7:1, brand-ember is 5.3:1. --}}
                <a href="https://wa.me/{{ $siteSettings->whatsapp_number }}?text=Hello%20Mounts%20Edge%20Regency!%20I%20would%20like%20to%20book%20a%20room."
                   target="_blank" rel="noopener noreferrer"
                   class="border border-brand-green/30 text-brand-green hover:border-brand-ember hover:text-brand-ember px-12 py-5 text-[11px] tracking-[0.2em] uppercase font-bold transition-colors duration-500">
                    WhatsApp Us
                </a>
            </div>
        </div>
    </div>
</section>
