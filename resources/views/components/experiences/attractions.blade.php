<section class="py-24 md:py-32 bg-white" 
         x-data="{ isVisible: false }" 
         x-intersect.once.margin.-15%.0.-15%.0="isVisible = true">
    
    <div class="container mx-auto px-6">
        <div class="text-center mb-16 reveal-hidden" :class="isVisible ? 'reveal-visible' : ''">
            <span class="text-brand-green/70 text-xs tracking-[0.2em] uppercase mb-4 block">Things to Do</span>
            <h2 class="text-4xl md:text-5xl font-serif text-brand-green mb-6">Curated Experiences</h2>
            <p class="text-brand-green/70 max-w-xl mx-auto font-light leading-relaxed">
                Our team can arrange guided tours to the best attractions in and around the Mahiyangana region [cite: 2026-02-01].
            </p>
        </div>

@php
            $attractions = [
                [
                    'name' => 'Waterfalls & Springs', 
                    'desc' => 'Discover stunning cascades and natural thermal springs hidden within the valleys.', 
                    'img' => 'https://go-srilanka.com/contentup/Rathna%20ella%20%20waterfall%20sri%20lanka.jpg',
                    'spots' => ['Rathna Ella', 'Dunhinda Fall', 'Maha Oya Hot Springs'],
                    'icon' => '<path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/>' // Droplets icon
                ],
                [
                    'name' => 'Heritage & Culture', 
                    'desc' => 'Explore sacred ancient temples, mythological ruins, and indigenous Vedda heritage.', 
                    'img' => 'https://storyofsrilanka.com/images/best-experiences-in-sri-lanka/indigenous-veddha-village-stay/indigenous-veddha-village-stay09.jpg',
                    'spots' => ['Mahiyangana Temple', 'Dambana Village', 'Seetha Kotuwa', 'Mawaragala'],
                    'icon' => '<path d="M3 21h18"/><path d="M3 7v1h18V7"/><path d="M5 21V8"/><path d="M9 21V8"/><path d="M15 21V8"/><path d="M19 21V8"/><path d="M2 4h20"/><path d="M12 2 2 7h20z"/>' // Landmark icon
                ],
                [
                    'name' => 'Nature & Wildlife', 
                    'desc' => 'Embark on thrilling safaris and scenic treks through pristine national parks and mountains.', 
                    'img' => 'https://cdn.jacadatravel.com/wp-content/uploads/bis-images/243900/Pinnawala-Habarana-Elephant-Orphanage1-2400x1400-f50_50.jpg',
                    'spots' => ['Wasgamuwa Park', 'Maduru Oya Park', 'Riverston', 'Meemure'],
                    'icon' => '<path d="m17 10 3-3 3 3"/><path d="M21 7v14"/><path d="m7 14 3-3 3 3"/><path d="M11 11v10"/><path d="m3 18 3-3 3 3"/><path d="M7 15v6"/>' // TreePine icon
                ],
                [
                    'name' => 'Scenic Landmarks', 
                    'desc' => 'Witness breathtaking panoramic views, ancient reservoirs, and massive engineering marvels.', 
                    'img' => 'https://i.ytimg.com/vi/RT-gosPguY8/hq720.jpg?sqp=-oaymwE7CK4FEIIDSFryq4qpAy0IARUAAAAAGAElAADIQj0AgKJD8AEB-AH-CYAC0AWKAgwIABABGDcgZShDMA8=&rs=AOn4CLDrmm3S2vevQCQUjNtrXPmg0t34aQ',
                    'spots' => ['18 Bends', 'Sorabora Wewa', 'Victoria Dam', 'Randenigala Dam'],
                    'icon' => '<path d="m8 3 4 8 5-5 5 15H2L8 3z"/>' // Mountain icon
                ],
            ];
        @endphp

        <div class="grid md:grid-cols-2 gap-12 max-w-6xl mx-auto">
            @foreach($attractions as $index => $item)
                <div class="group flex flex-col lg:flex-row gap-8 p-10 border border-brand-green/20 bg-[#fdfdfb] hover:border-brand-orange/30 transition-all duration-500 reveal-hidden"
                     style="transition-delay: {{ $index * 150 }}ms"
                     :class="isVisible ? 'reveal-visible' : ''">
                    
                    <div class="lg:w-1/3 shrink-0">
                        <div class="aspect-square overflow-hidden shadow-md">
                            <img src="{{ $item['img'] }}" class="w-full h-full object-cover transition-transform duration-[2000ms] group-hover:scale-110">
                        </div>
                    </div>

                    <div class="flex-1">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-10 h-10 border border-brand-green/30 flex items-center justify-center text-brand-green">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                                    {!! $item['icon'] !!}
                                </svg>
                            </div>
                            <h3 class="text-2xl font-serif text-brand-green">{{ $item['name'] }}</h3>
                        </div>
                        <p class="text-brand-green/70 text-sm mb-6 font-light leading-relaxed">{{ $item['desc'] }}</p>
                        
                        <div class="flex flex-wrap gap-2">
                            @foreach($item['spots'] as $spot)
                                <span class="text-[9px] tracking-widest uppercase border border-brand-green/20 bg-white text-brand-green/70 px-3 py-1.5">
                                    {{ $spot }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>