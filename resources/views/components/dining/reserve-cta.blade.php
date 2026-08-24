<section class="bg-brand-green py-12 md:py-20 text-center"
         x-data="{ isVisible: false }"
         x-intersect.once.margin.-25%.0.-25%.0="isVisible = true">
    <div class="container mx-auto px-6 reveal-hidden" :class="isVisible ? 'reveal-visible' : ''">
        <h3 class="text-3xl md:text-4xl font-serif text-brand-light mb-4">Reserve Your Table</h3>
        <p class="text-[#F5F5DC]/70 mb-8 max-w-xl mx-auto font-light">
            Tell us the date, time and how many are joining you, and we'll take care of the rest
        </p>

        <div class="flex flex-wrap items-center justify-center gap-3">
            <a href="{{ route('contact', ['type' => \App\Models\Enquiry::TYPE_DINING]) }}"
               class="bg-brand-light hover:bg-brand-orange hover:text-brand-light text-brand-green px-12 py-5 text-[10px] tracking-[0.2em] uppercase font-bold transition-colors">
                Reserve a Table
            </a>

            <a href="https://wa.me/{{ $siteSettings->whatsapp_number }}?text=Hello%20Mounts%20Edge%20Regency!%20I%20would%20like%20to%20reserve%20a%20table."
               target="_blank" rel="noopener noreferrer"
               class="border border-brand-light/60 text-brand-light hover:border-brand-orange hover:text-brand-orange px-12 py-5 text-[10px] tracking-[0.2em] uppercase font-bold transition-colors">
                WhatsApp Us
            </a>
        </div>
    </div>
</section>
