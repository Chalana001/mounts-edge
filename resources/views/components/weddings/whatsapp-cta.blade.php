<section class="bg-brand-orange/10 py-16">
    <div class="container mx-auto px-6 text-center">
        <div class="flex flex-col md:flex-row items-center justify-center gap-8">
            <div class="text-left">
                <h3 class="text-2xl md:text-3xl font-serif text-brand-green mb-2">Ready to Plan Your Wedding?</h3>
                <p class="text-brand-green/70 font-light">Chat with our events team on WhatsApp — or see our <a href="{{ route('dining') }}" class="underline hover:text-brand-ember">dining</a> and <a href="{{ route('gallery') }}" class="underline hover:text-brand-ember">gallery</a></p>
            </div>
            
            <div class="flex flex-wrap items-center justify-center gap-3">
                <a href="{{ route('contact', ['type' => \App\Models\Enquiry::TYPE_WEDDING]) }}"
                   class="flex items-center gap-3 bg-brand-green hover:bg-brand-hover text-brand-light rounded-none px-8 py-4 text-[11px] tracking-[0.15em] uppercase font-bold transition-colors focus:outline-none cursor-pointer focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-orange focus-visible:ring-offset-2">
                    Send an Enquiry
                </a>

                <a href="https://wa.me/{{ $siteSettings->whatsapp_number }}?text=Hello%20Mounts%20Edge%20Regency!%20I%20would%20like%20to%20plan%20my%20wedding."
                   target="_blank" rel="noopener noreferrer"
                   class="flex items-center gap-3 border border-brand-green text-brand-green hover:border-brand-orange hover:text-brand-ember rounded-none px-8 py-4 text-[11px] tracking-[0.15em] uppercase font-bold transition-colors focus:outline-none cursor-pointer focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-orange focus-visible:ring-offset-2">

                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 1 1-7.6-10.6 8.38 8.38 0 0 1 3.9 1.1L21 3.5Z"/>
                    </svg>
                    WhatsApp Us
                </a>
            </div>
            
        </div>
    </div>
</section>
