{{-- Both actions stack in the bottom-right corner. They used to sit in opposite
     corners on the Contact page only, which framed the page in floating chrome and
     put back-to-top in the harder corner to reach one-handed. WhatsApp is the
     primary booking channel, so it keeps the corner and back-to-top sits above it. --}}
<div class="fixed bottom-6 right-6 z-50 flex flex-col items-center gap-3"
     x-data="{ scrolled: false }"
     x-init="scrolled = window.scrollY > 400;
             window.addEventListener('scroll', () => scrolled = window.scrollY > 400)">

    <button type="button"
            x-show="scrolled"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
            aria-label="Back to top"
            class="flex h-11 w-11 items-center justify-center rounded-full bg-brand-green text-brand-light shadow-xl transition-all hover:bg-brand-hover focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-orange focus-visible:ring-offset-2"
            style="display: none;">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m18 15-6-6-6 6"/></svg>
    </button>

    <a href="https://wa.me/{{ $siteSettings->whatsapp_number }}?text=Hello%20Mounts%20Edge%20Regency!%20I%20would%20like%20to%20make%20an%20inquiry."
       target="_blank" rel="noopener noreferrer"
       aria-label="Chat with us on WhatsApp"
       data-conversion="contact_whatsapp_click"
       class="flex h-14 w-14 items-center justify-center rounded-full bg-whatsapp text-white shadow-2xl transition-transform hover:scale-110 focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-orange focus-visible:ring-offset-2">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 1 1-7.6-10.6 8.38 8.38 0 0 1 3.9 1.1L21 3.5Z"/></svg>
    </a>
</div>
