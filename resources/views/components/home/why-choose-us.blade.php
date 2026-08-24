<section class="py-12 md:py-20 bg-[#f9f9f7]"
         x-data="{ isVisible: false }" 
         x-intersect.once.margin.-25%.0.-25%.0="isVisible = true">
    
    <div class="container mx-auto px-6">
        
        <div class="text-center mb-10 md:mb-14 reveal-fade"
             :class="isVisible ? 'reveal-visible' : ''">
            <span class="text-brand-green/70 text-xs tracking-[0.3em] uppercase font-light block mb-4">
                The Difference
            </span>
            <h2 class="text-3xl md:text-4xl font-serif text-brand-green font-normal">
                Why Mounts Edge
            </h2>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-10 lg:gap-16 max-w-6xl mx-auto">
@php
    $features = [
        [
            'title' => 'Mountain Retreat',
            'description' => 'A quiet retreat high in the Mahiyangana mountains, with sweeping views across the valley.',
            'svg' => '<path d="m8 3 4 8 5-5 5 15H2L8 3z"/>' // Mountain icon
        ],
        [
            'title' => 'Tranquil Wilderness',
            'description' => 'Comfortable, well-appointed rooms set right in the middle of untouched highland nature.',
            'svg' => '<path d="m12 13 3 3m-3-3-3 3m3-3V7m0 13a8 8 0 1 0 0-16 8 8 0 0 0 0 16z"/><path d="M12 2v2m0 16v2M2 12h2m16 0h2"/>' // Leaf/Nature icon
        ],
        [
            'title' => 'Secluded Infinity Pool',
            'description' => 'A private pool with an uninterrupted view of the mountain horizon.',
            'svg' => '<path d="M2 6c.6.5 1.2 1 2.5 1C7 7 7 5 9.5 5c2.6 0 2.4 2 5 2 2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1"/><path d="M2 12c.6.5 1.2 1 2.5 1 2.5 0 2.5-2 5-2 2.6 0 2.4 2 5 2 2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1"/><path d="M2 18c.6.5 1.2 1 2.5 1 2.5 0 2.5-2 5-2 2.6 0 2.4 2 5 2 2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1"/>' // Water/Pool icon
        ],
        [
            'title' => 'Culinary Excellence',
            'description' => 'Sri Lankan and international dishes, cooked fresh by our kitchen team.',
            'svg' => '<path d="M6 13.87A4 4 0 0 1 7.41 6a5.11 5.11 0 0 1 1.05-1.54 5 5 0 0 1 7.08 0A5.11 5.11 0 0 1 16.59 6 4 4 0 0 1 18 13.87V21H6Z"/><line x1="6" y1="17" x2="18" y2="17"/>' // Chef hat icon
        ]
    ];
@endphp

            @foreach($features as $index => $feature)
                <div class="text-center reveal-scale"
                     style="transition-delay: {{ ($index + 1) * 150 }}ms"
                     :class="isVisible ? 'reveal-visible' : ''">
                    
                    <div class="mb-3 md:mb-6 flex justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="text-brand-green w-7 h-7 md:w-8 md:h-8">
                            {!! $feature['svg'] !!}
                        </svg>
                    </div>

                    <h3 class="text-sm md:text-lg font-serif text-brand-green mb-2 md:mb-3">{{ $feature['title'] }}</h3>
                    <p class="text-brand-green/70 text-xs md:text-sm leading-relaxed font-light px-0 md:px-4">
                        {{ $feature['description'] }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>
</section>
