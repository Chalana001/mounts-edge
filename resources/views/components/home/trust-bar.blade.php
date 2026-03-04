<section class="py-20 md:py-24 bg-brand-green" 
         x-data="{ isVisible: false }" 
         x-intersect.once.margin.-25%.0.-25%.0="isVisible = true">
    
    <div class="container mx-auto px-6">
        <div class="flex flex-col md:flex-row items-center justify-center gap-12 md:gap-24 lg:gap-32">
            
            @php
                $stats = [
                    ['value' => '4.9', 'label' => 'Guest Rating'],
                    ['value' => '500+', 'label' => 'Weddings Hosted'],
                    ['value' => '12', 'label' => 'Years of Service'],
                ];
            @endphp

            @foreach($stats as $index => $stat)
                <div class="text-center reveal-hidden"
                     style="transition-delay: {{ $index * 150 }}ms"
                     :class="isVisible ? 'reveal-visible' : ''">
                    
                    <div class="text-4xl md:text-5xl font-serif text-[#F5F5DC] mb-3">
                        {{ $stat['value'] }}
                    </div>
                    
                    <div class="text-[#F5F5DC]/50 text-[10px] tracking-[0.3em] uppercase font-light">
                        {{ $stat['label'] }}
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</section>