<section class="bg-brand-orange/10 py-16">
    <div class="container mx-auto px-6 text-center">
        <div class="flex flex-col md:flex-row items-center justify-center gap-8">
            <div class="text-left">
                <h3 class="text-2xl md:text-3xl font-serif text-brand-green mb-2">Ready to Plan Your Wedding?</h3>
                <p class="text-brand-green/70 font-light">Chat with our events team on WhatsApp for quick responses</p>
            </div>
            
            <button x-data 
               @click.prevent="
                   fetch('/notify-whatsapp', {
                       method: 'POST',
                       headers: {
                           'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content'),
                           'Accept': 'application/json'
                       }
                   });
                   
                   window.open('https://wa.me/94704589764?text=Hello%20Mounts%20Edge%20Regency!%20I%20would%20like%20to%20plan%20my%20wedding.', '_blank');
               "
               class="flex items-center gap-3 bg-brand-green hover:bg-brand-orange text-brand-light rounded-none px-8 py-4 text-[10px] tracking-[0.15em] uppercase font-bold transition-colors focus:outline-none cursor-pointer">
                
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 1 1-7.6-10.6 8.38 8.38 0 0 1 3.9 1.1L21 3.5Z"/>
                </svg>
                WhatsApp Us
            </button>
            
        </div>
    </div>
</section>