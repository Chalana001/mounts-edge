<section class="py-24 bg-[#FAF9F6] relative">
    <div class="container mx-auto px-6 max-w-4xl">
        
        <div class="text-center mb-16">
            <span class="text-[10px] tracking-[0.4em] uppercase text-brand-green/70 mb-4 block font-bold">Send a Message</span>
            <h2 class="text-4xl md:text-5xl font-serif text-[#1a2e2a] mb-6">Make an Inquiry</h2>
            <p class="text-brand-green/70 font-light italic">Fill out the form below and we'll get back to you as soon as possible [cite: 2026-02-18]</p>
        </div>

        <form action="#" method="POST" class="space-y-8">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label class="text-[11px] font-bold uppercase tracking-widest text-[#1a2e2a]">Full Name *</label>
                    <input type="text" placeholder="Your full name" class="w-full bg-brand-light border border-brand-green/30 p-4 text-sm font-light focus:border-brand-orange focus:ring-0 transition-all outline-none">
                </div>
                <div class="space-y-2">
                    <label class="text-[11px] font-bold uppercase tracking-widest text-[#1a2e2a]">Email Address *</label>
                    <input type="email" placeholder="your@email.com" class="w-full bg-brand-light border border-brand-green/30 p-4 text-sm font-light focus:border-brand-orange focus:ring-0 transition-all outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label class="text-[11px] font-bold uppercase tracking-widest text-[#1a2e2a]">Phone Number *</label>
                    <input type="text" placeholder="+94 77 123 4567" class="w-full bg-brand-light border border-brand-green/30 p-4 text-sm font-light focus:border-brand-orange focus:ring-0 transition-all outline-none">
                </div>
                <div class="space-y-2">
                    <label class="text-[11px] font-bold uppercase tracking-widest text-[#1a2e2a]">Inquiry Type *</label>
                    <select class="w-full bg-brand-light border border-brand-green/30 p-4 text-sm font-light focus:border-brand-orange focus:ring-0 transition-all outline-none appearance-none cursor-pointer">
                        <option>Select inquiry type</option>
                        <option>Room Booking</option>
                        <option>Wedding Inquiry</option>
                        <option>Dining Reservation</option>
                    </select>
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-[11px] font-bold uppercase tracking-widest text-[#1a2e2a]">Message *</label>
                <textarea rows="6" placeholder="Tell us about your plans..." class="w-full bg-brand-light border border-brand-green/30 p-4 text-sm font-light focus:border-brand-orange focus:ring-0 transition-all outline-none resize-none"></textarea>
            </div>

            <div class="text-center pt-4">
                <button type="submit" class="w-full bg-[#1a2e2a] text-brand-light hover:bg-[#2a453f] px-12 py-5 text-[11px] tracking-[0.2em] uppercase font-bold transition-all duration-500 shadow-xl">
                    Send Message
                </button>
            </div>
        </form>
    </div>

    <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})" 
            class="fixed bottom-8 left-8 w-12 h-12 bg-[#1a2e2a] text-brand-light flex items-center justify-center rounded-full shadow-2xl hover:scale-110 transition-transform z-50">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m18 15-6-6-6 6"/></svg>
    </button>

    <a href="https://wa.me/94704589764" target="_blank"
       class="fixed bottom-8 right-8 w-14 h-14 bg-[#25D366] text-brand-light flex items-center justify-center rounded-full shadow-2xl hover:scale-110 transition-transform z-50">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 1 1-7.6-10.6 8.38 8.38 0 0 1 3.9 1.1L21 3.5Z"/></svg>
    </a>
</section>