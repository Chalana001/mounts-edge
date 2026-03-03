<section class="py-32 md:py-40 bg-white" 
         x-data="{ isVisible: false }" 
         x-intersect.once.margin.-20%.0.-20%.0="isVisible = true">
    
    <div class="container mx-auto px-6">
        
        <div class="text-center mb-20 reveal-hidden"
             :class="isVisible ? 'reveal-visible' : ''">
            <span class="text-brand-green/70 text-xs tracking-[0.3em] uppercase font-light block mb-4">
                Experiences
            </span>
            <h2 class="text-3xl md:text-4xl font-serif text-brand-green font-normal">
                Two Journeys, One Destination
            </h2>
        </div>

        <div class="grid md:grid-cols-2 gap-8 lg:gap-16 max-w-5xl mx-auto">
            @php
                $experiences = [
                    [
                        'title' => 'Stay',
                        'subtitle' => 'Mountain Retreat',
                        'description' => 'Wake to mist-wrapped peaks and the quiet of nature',
                        'image' => '/storage/home/experiences/stay.jpg',
                        'link' => '/luxury-stay',
                    ],
                    [
                        'title' => 'Celebrate',
                        'subtitle' => 'Weddings & Events',
                        'description' => 'Intimate gatherings with mountains as your witness',
                        'image' => '/storage/home/experiences/weddings.jpg',
                        'link' => '/weddings',
                    ],
                ];
            @endphp

            @foreach($experiences as $index => $exp)
                <div class="reveal-hidden"
                     style="transition-delay: {{ ($index + 1) * 250 }}ms"
                     :class="isVisible ? 'reveal-visible' : ''">
                    
                    <a href="{{ $exp['link'] }}" class="group block">
                        <div class="relative overflow-hidden aspect-[4/5] mb-8 shadow-sm">
                            <div class="absolute inset-0 bg-cover bg-center transition-transform duration-[1500ms] ease-out group-hover:scale-110"
                                 style="background-image: url('{{ $exp['image'] }}')">
                            </div>
                            <div class="absolute inset-0 bg-black/5 group-hover:bg-black/0 transition-colors duration-500"></div>
                        </div>

                        <div>
                            <span class="text-brand-green/70 text-[10px] tracking-[0.3em] uppercase font-bold">
                                {{ $exp['subtitle'] }}
                            </span>
                            <h3 class="text-2xl md:text-3xl font-serif text-brand-green mt-2 mb-3 transition-colors duration-500 group-hover:text-brand-orange">
                                {{ $exp['title'] }}
                            </h3>
                            <p class="text-brand-green/70 text-sm font-light leading-relaxed mb-6">
                                {{ $exp['description'] }}
                            </p>
                            
                            <div class="flex items-center gap-2 text-brand-green transition-all duration-500 group-hover:gap-4 font-bold tracking-widest text-[10px] uppercase">
                                <span>Explore</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>
                                </svg>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>