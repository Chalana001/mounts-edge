<section class="py-24 md:py-32 bg-white">
    <div class="container mx-auto px-6 text-center mb-16 reveal-hidden"
         x-data="{ isHeadingVisible: false }"
         x-intersect.once.margin.-15%.0.-15%.0="isHeadingVisible = true"
         :class="isHeadingVisible ? 'reveal-visible' : ''"
         style="transition-duration: 1.2s;">
        <span class="text-brand-green/70 text-xs tracking-[0.2em] uppercase mb-4 block">Where to Eat & Drink</span>
        <h2 class="text-4xl md:text-5xl font-serif text-brand-green">Our Dining Spaces</h2>
    </div>

    <div class="flex flex-wrap justify-center gap-8 max-w-5xl mx-auto px-6">
        @php
            $spaces = [
                ['name' => 'Main Restaurant', 'hours' => '6:30 AM - 10:00 PM', 'desc' => 'All-day dining with mountain views', 'icon' => '<path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2"/><path d="M7 2v20"/><path d="M21 15V2v0a5 5 0 0 0-5 5v6c0 1.1.9 2 2 2h3Zm0 0v7"/>'],
                ['name' => 'The Terrace Bar', 'hours' => '5:00 PM - 11:00 PM', 'desc' => 'Cocktails and evening ambiance', 'icon' => '<path d="M8 22h8"/><path d="M12 11v11"/><path d="m19 2-7 9-7-9Z"/>']
            ];
        @endphp

        @foreach($spaces as $space)
            <div class="w-full md:w-[320px] text-center p-12 border border-brand-green/20 hover:border-brand-orange/30 transition-all duration-500 bg-[#fdfdfb] reveal-hidden"
                 x-data="{ isCardVisible: false }"
                 x-intersect.once.margin.-10%.0.-10%.0="isCardVisible = true"
                 :class="isCardVisible ? 'reveal-visible' : ''"
                 style="transition-duration: 1.5s; transition-delay: {{ $loop->index * 200 }}ms;">
                 
                <div class="w-12 h-12 mx-auto mb-8 border border-brand-green/30 flex items-center justify-center text-brand-green">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                        {!! $space['icon'] !!}
                    </svg>
                </div>
                <h3 class="font-serif text-brand-green text-xl mb-3">{{ $space['name'] }}</h3>
                <p class="text-[10px] tracking-[0.2em] uppercase text-brand-orange font-bold mb-4">{{ $space['hours'] }}</p>
                <p class="text-brand-green/70 text-sm font-light leading-relaxed">{{ $space['desc'] }}</p>
            </div>
        @endforeach
    </div>
</section>