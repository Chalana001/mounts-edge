<section class="h-[450px] bg-brand-light relative grayscale hover:grayscale-0 transition-all duration-1000 overflow-hidden">
    <div class="absolute inset-0 flex flex-col items-center justify-center bg-brand-green/10">
        <div class="bg-white p-8 text-center shadow-2xl border border-brand-light reveal-hidden"
             x-data="{ visible: false }" x-init="setTimeout(() => visible = true, 500)" :class="visible ? 'reveal-visible' : ''">
            <svg class="w-10 h-10 text-brand-orange mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
            <h4 class="font-serif text-brand-green text-xl mb-2">Find Us</h4>
            <p class="text-brand-green/70 text-sm font-light mb-6">Gurulupotha, Mahiyangana, Sri Lanka [cite: 2026-02-18]</p>
            <a href="https://maps.google.com" target="_blank" class="text-[10px] tracking-widest uppercase font-bold text-brand-green underline underline-offset-8 hover:text-brand-orange transition-colors">
                Open in Google Maps
            </a>
        </div>
    </div>
</section>