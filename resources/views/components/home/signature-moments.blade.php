<section class="py-32 md:py-40 bg-white" 
         x-data="{ isVisible: false }" 
         x-intersect.once.margin.-25%.0.-25%.0="isVisible = true">
    
    <div class="container mx-auto px-6">
        
        <div class="text-center mb-16 reveal-hidden"
             :class="isVisible ? 'reveal-visible' : ''">
            <span class="text-brand-green/70 text-[10px] tracking-[0.4em] uppercase font-bold block mb-4">
                Moments
            </span>
            <h2 class="text-3xl md:text-4xl font-serif text-brand-green font-normal">
                Captured Here
            </h2>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 max-w-6xl mx-auto">
            @php
                $moments = [
                    [
                        'title' => 'Sunrise',
                        'image' => '/storage/home/signature-moments/sunrise.jpg',
                    ],
                    [
                        'title' => 'Pool',
                        'image' => '/storage/home/signature-moments/pool.jpg',
                    ],
                    [
                        'title' => 'Celebration',
                        'image' => '/storage/home/signature-moments/celebration.jpg',
                    ],
                    [
                        'title' => 'Dining',
                        'image' => '/storage/home/signature-moments/dining.jpg',
                    ],
                ];
            @endphp

            @foreach($moments as $index => $moment)
                <div class="group relative overflow-hidden aspect-[3/4] reveal-hidden shadow-sm"
                     style="transition-delay: {{ ($index + 1) * 150 }}ms"
                     :class="isVisible ? 'reveal-visible' : ''">
                    
                    <div class="absolute inset-0 bg-cover bg-center transition-transform duration-[1500ms] ease-out group-hover:scale-110"
                         style="background-image: url('{{ $moment['image'] }}')">
                    </div>

                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-colors duration-500 flex items-end p-6">
                        <span class="text-brand-light text-[10px] tracking-[0.2em] uppercase font-bold translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-500">
                            {{ $moment['title'] }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>