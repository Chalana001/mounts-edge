<section class="py-32 md:py-40 bg-[#f9f9f7]" 
         x-data="{ isVisible: false }" 
         x-intersect.once.margin.-20%.0.-20%.0="isVisible = true">
    
    <div class="container mx-auto px-6">
        
        <div class="text-center mb-20 reveal-hidden"
             :class="isVisible ? 'reveal-visible' : ''">
            <span class="text-brand-green/70 text-xs tracking-[0.3em] uppercase font-light block mb-4">
                The Difference
            </span>
            <h2 class="text-3xl md:text-4xl font-serif text-brand-green font-normal">
                Why Mounts Edge
            </h2>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-12 lg:gap-16 max-w-6xl mx-auto">
@php
    $features = [
        [
            'title' => 'Mountain Retreat', // කන්දක් උඩ තියෙන බව කියන්න
            'description' => 'A serene haven nestled high in the Mahiyangana mountains with breathtaking panoramic views.',
            'svg' => '<path d="m8 3 4 8 5-5 5 15H2L8 3z"/>' // Mountain icon
        ],
        [
            'title' => 'Tranquil Wilderness', // Nature First වෙනුවට
            'description' => 'Immerse yourself in nature\'s beauty where luxury meets the untouched highland environment.',
            'svg' => '<path d="m12 13 3 3m-3-3-3 3m3-3V7m0 13a8 8 0 1 0 0-16 8 8 0 0 0 0 16z"/><path d="M12 2v2m0 16v2M2 12h2m16 0h2"/>' // Leaf/Nature icon
        ],
        [
            'title' => 'Secluded Infinity Pool', // Privacy එක highlight කරන්න
            'description' => 'An exclusive, completely private pool seamlessly blending into the mountain horizon.',
            'svg' => '<path d="M2 6c.6.5 1.2 1 2.5 1C7 7 7 5 9.5 5c2.6 0 2.4 2 5 2 2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1"/><path d="M2 12c.6.5 1.2 1 2.5 1 2.5 0 2.5-2 5-2 2.6 0 2.4 2 5 2 2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1"/><path d="M2 18c.6.5 1.2 1 2.5 1 2.5 0 2.5-2 5-2 2.6 0 2.4 2 5 2 2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1"/>' // Water/Pool icon
        ],
        [
            'title' => 'Culinary Excellence', // Local Craft වෙනුවට කෑම ගැන කියන්න
            'description' => 'Savor exquisite Sri Lankan and international cuisine prepared by our master chefs.',
            'svg' => '<path d="M6 13.87A4 4 0 0 1 7.41 6a5.11 5.11 0 0 1 1.05-1.54 5 5 0 0 1 7.08 0A5.11 5.11 0 0 1 16.59 6 4 4 0 0 1 18 13.87V21H6Z"/><line x1="6" y1="17" x2="18" y2="17"/>' // Chef Hat icon (කලින් තිබ්බ පිහිය වෙනුවට මේක දැම්මා)
        ]
    ];
@endphp

            @foreach($features as $index => $feature)
                <div class="text-center reveal-hidden"
                     style="transition-delay: {{ ($index + 1) * 150 }}ms"
                     :class="isVisible ? 'reveal-visible' : ''">
                    
                    <div class="mb-6 flex justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="text-brand-green">
                            {!! $feature['svg'] !!}
                        </svg>
                    </div>

                    <h3 class="text-lg font-serif text-brand-green mb-3">{{ $feature['title'] }}</h3>
                    <p class="text-brand-green/70 text-sm leading-relaxed font-light px-4">
                        {{ $feature['description'] }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>
</section>