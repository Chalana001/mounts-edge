<section class="py-10 md:py-16 bg-brand-green"
         x-data="{ isVisible: false }" 
         x-intersect.once.margin.-25%.0.-25%.0="isVisible = true">
    
    <div class="container mx-auto px-6">
        <div class="flex flex-row items-start justify-center gap-6 sm:gap-12 md:gap-16 lg:gap-20">

            @php
                // target/decimals/suffix drive the count-up; `value` is the
                // fallback shown if JavaScript never runs.
                $stats = [
                    ['value' => '4.9', 'target' => 4.9, 'decimals' => 1, 'suffix' => '', 'label' => 'Guest Rating'],
                    ['value' => '500+', 'target' => 500, 'decimals' => 0, 'suffix' => '+', 'label' => 'Weddings Hosted'],
                    ['value' => '12', 'target' => 12, 'decimals' => 0, 'suffix' => '', 'label' => 'Years of Service'],
                ];
            @endphp

            @foreach($stats as $index => $stat)
                <div class="text-center reveal-scale flex-1 md:flex-none max-w-[33%] md:max-w-none"
                     style="transition-delay: {{ $index * 150 }}ms"
                     :class="isVisible ? 'reveal-visible' : ''">

                    <div class="text-2xl sm:text-4xl md:text-5xl font-serif text-[#F5F5DC] mb-2 md:mb-3 tabular-nums"
                         x-data="countUp({{ $stat['target'] }}, {{ $stat['decimals'] }}, @js($stat['suffix']))"
                         x-intersect.once.margin.-15%.0.-15%.0="start()"
                         x-text="display">{{ $stat['value'] }}</div>

                    <div class="text-[#F5F5DC]/50 text-[8px] sm:text-[10px] tracking-[0.2em] sm:tracking-[0.3em] uppercase font-light leading-tight">
                        {{ $stat['label'] }}
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</section>