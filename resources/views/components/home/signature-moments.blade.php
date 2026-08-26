<section class="py-12 md:py-20 bg-white"
         x-data="{ isVisible: false }" 
         x-intersect.once.margin.-25%.0.-25%.0="isVisible = true">
    
    <div class="container mx-auto px-6">
        
        <div class="text-center mb-10 md:mb-14 reveal-fade"
             :class="isVisible ? 'reveal-visible' : ''">
            <span class="text-brand-green/70 text-[11px] tracking-[0.4em] uppercase font-bold block mb-4">
                Moments
            </span>
            <h2 class="text-3xl md:text-4xl font-serif text-brand-green font-normal">
                Captured Here
            </h2>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 max-w-6xl mx-auto">
            @php
                // width/height are the real intrinsic dimensions of each file, and
                // image400 is the variant produced by scripts/generate-variants.php.
                $moments = [
                    [
                        'title'  => 'Sunrise',
                        'alt'    => 'Sunrise over the mountains at Mounts Edge Regency',
                        'image'  => '/storage/home/signature-moments/sunrise.jpg',
                        'image400' => '/storage/home/signature-moments/sunrise-400w.jpg',
                        'width'  => 800, 'height' => 800,
                    ],
                    [
                        'title'  => 'Pool',
                        'alt'    => 'The infinity pool at Mounts Edge Regency',
                        'image'  => '/storage/home/signature-moments/pool.jpg',
                        'image400' => '/storage/home/signature-moments/pool-400w.jpg',
                        'width'  => 800, 'height' => 800,
                    ],
                    [
                        'title'  => 'Celebration',
                        'alt'    => 'A celebration held at Mounts Edge Regency',
                        'image'  => '/storage/home/signature-moments/celebration.jpg',
                        'image400' => '/storage/home/signature-moments/celebration-400w.jpg',
                        'width'  => 800, 'height' => 800,
                    ],
                    [
                        'title'  => 'Dining',
                        'alt'    => 'Dining at Mounts Edge Regency',
                        'image'  => '/storage/home/signature-moments/dining.jpg',
                        'image400' => '/storage/home/signature-moments/dining-400w.jpg',
                        'width'  => 600, 'height' => 800,
                    ],
                ];
            @endphp

            @foreach($moments as $index => $moment)
                <div class="group relative overflow-hidden aspect-[3/4] reveal-scale shadow-sm"
                     style="transition-delay: {{ ($index + 1) * 150 }}ms"
                     :class="isVisible ? 'reveal-visible' : ''">
                    
                    {{-- An <img> rather than a CSS background: these four sit well below
                         the fold, and background-image has no lazy-loading equivalent, so
                         as backgrounds they were fetched on first paint every time.
                         object-cover reproduces bg-cover/bg-center exactly. --}}
                    <x-responsive-image :src="$moment['image']"
                                        :widths="[400, 800]"
                                        sizes="(min-width: 768px) 270px, 45vw"
                                        :alt="$moment['alt']"
                                        loading="lazy" decoding="async"
                                        class="absolute inset-0 w-full h-full object-cover transition-transform duration-[1500ms] ease-out group-hover:scale-110" />

                    {{-- Touch devices never fire :hover, so the label sits on a permanent scrim on
                         mobile and only uses the fade-in reveal from md up. --}}
                    <div class="absolute inset-0 flex items-end p-6 bg-gradient-to-t from-black/70 to-transparent transition-colors duration-500 md:bg-none md:bg-black/0 md:group-hover:bg-black/40">
                        <span class="text-brand-light text-[11px] tracking-[0.2em] uppercase font-bold transition-all duration-500 md:translate-y-4 md:opacity-0 md:group-hover:translate-y-0 md:group-hover:opacity-100">
                            {{ $moment['title'] }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>