<section class="bg-brand-green py-16 text-center">
    <div class="container mx-auto px-6">
        <h3 class="text-3xl md:text-4xl font-serif text-brand-light mb-4">Ready to Book Your Stay?</h3>
        <p class="text-[#F5F5DC]/70 mb-8 max-w-xl mx-auto font-light">
            Reserve your room directly for the best rates and instant confirmation
        </p>
        
        <div class="flex flex-wrap items-center justify-center gap-3">
            <a href="{{ route('contact', ['type' => \App\Models\Enquiry::TYPE_ROOM]) }}"
               class="bg-brand-light hover:bg-brand-orange hover:text-brand-light text-brand-green px-12 py-5 text-[10px] tracking-[0.2em] uppercase font-bold transition-colors">
                Book Now
            </a>

            <a href="https://wa.me/{{ $siteSettings->whatsapp_number }}?text=Hello%20Mounts%20Edge%20Regency!%20I%20would%20like%20to%20book%20a%20room."
               target="_blank" rel="noopener noreferrer"
               class="border border-brand-light/60 text-brand-light hover:border-brand-orange hover:text-brand-orange px-12 py-5 text-[10px] tracking-[0.2em] uppercase font-bold transition-colors">
                WhatsApp Us
            </a>
        </div>
        
    </div>
</section>
