<section class="py-24 md:py-32 bg-white" 
         x-data="{ isVisible: false }" 
         x-intersect.once.margin.-25%.0px.-25%.0px="isVisible = true">
    
    <div class="container mx-auto px-6">
        <div class="text-center mb-16 reveal-hidden" :class="isVisible ? 'reveal-visible' : ''" style="transition-duration: 1.2s;">
            <span class="text-brand-green/70 text-xs tracking-[0.2em] uppercase mb-4 block">Things to Do</span>
            <h2 class="text-4xl md:text-5xl font-serif text-brand-green mb-6">Curated Experiences</h2>
            <p class="text-brand-green/70 max-w-xl mx-auto font-light leading-relaxed">
                Explore a handpicked collection of thrilling adventures and cultural immersions around our beautiful region.
            </p>
        </div>

        @php
            $experiences = [
                [
                    'name' => 'Cycle Tour', 
                    'desc' => 'Discover local villages, lush paddy fields, and scenic trails on a guided bicycle tour.', 
                    'img' => 'storage/experiences/attractions/cycle-tour.jpg',
                    'icon' => '<circle cx="5.5" cy="17.5" r="3.5"/><circle cx="18.5" cy="17.5" r="3.5"/><path d="M15 6a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-3 11.5V14l-3-3 4-3 2 3h2"/>' // Bicycle
                ],
                [
                    'name' => 'Wildlife Safari', 
                    'desc' => 'Embark on a thrilling jeep safari to spot majestic wild elephants and diverse wildlife.', 
                    'img' => 'storage/experiences/attractions/wildlife-safari.jpg',
                    'icon' => '<path d="M10 10h4"/><path d="M19 7V4a1 1 0 0 0-1-1h-2a1 1 0 0 0-1 1v3"/><path d="M20 21a2 2 0 0 0 2-2v-3.851c0-1.39-2-2.962-2-4.829V8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v11a2 2 0 0 0 2 2h4z"/><path d="M9 7V4a1 1 0 0 0-1-1H6a1 1 0 0 0-1 1v3"/><path d="M4 21a2 2 0 0 1-2-2v-3.851c0-1.39 2-2.962 2-4.829V8a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v11a2 2 0 0 1-2 2H4z"/>' // Binoculars
                ],
                [
                    'name' => 'BBQ Night', 
                    'desc' => 'Enjoy a starlit barbecue dining experience with a private chef in the cool mountain breeze.', 
                    'img' => 'storage/experiences/attractions/bbq-night.png',
                    'icon' => '<path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"/>' // Flame
                ],
                [
                    'name' => 'Traditional Kitchen', 
                    'desc' => 'Learn the secrets of authentic Sri Lankan spices and traditional clay-pot cooking.', 
                    'img' => 'storage/experiences/attractions/traditional-kitchen.webp',
                    'icon' => '<path d="M6 13.87A4 4 0 0 1 7.41 6a5.11 5.11 0 0 1 1.05-1.54 5 5 0 0 1 7.08 0A5.11 5.11 0 0 1 16.59 6 4 4 0 0 1 18 13.87V21H6Z"/><line x1="6" y1="17" x2="18" y2="17"/>' // Chef Hat
                ],
                [
                    'name' => 'Aboriginal Culture', 
                    'desc' => 'Visit the local Vedda community and experience their ancient, indigenous way of life.', 
                    'img' => 'storage/experiences/attractions/aboriginal-culture.jfif',
                    'icon' => '<path d="M19 20 10 4"/><path d="m5 20 9-16"/><path d="M3 20h18"/><path d="m12 15-3 5"/><path d="m12 15 3 5"/>' // Tent/Tribal
                ],
                [
                    'name' => 'Yoga Session', 
                    'desc' => 'Find your inner peace with sunrise yoga overlooking the misty peaks and valleys.', 
                    'img' => 'storage/experiences/attractions/yoga-session.webp',
                    'icon' => '<path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/>' // Wellness Heart
                ],
                [
                    'name' => 'Paragliding', 
                    'desc' => 'Soar above the mountains and valleys for an adrenaline-pumping aerial view.', 
                    'img' => 'storage/experiences/attractions/paragliding.jpg',
                    'icon' => '<path d="M4 22 22 4"/><path d="M22 16.4V4h-12.4l-4.3 4.3c-1 1-1 2.6 0 3.6l5.2 5.2c1 1 2.6 1 3.6 0L22 16.4z"/><path d="m11 13-6 6"/>' // Parachute/Kite
                ],
                [
                    'name' => 'Lake Boat Ride', 
                    'desc' => 'Experience a tranquil traditional boat ride on the historic Sorabora Wewa at sunrise.', 
                    'img' => 'storage/experiences/attractions/boat-ride.jpg',
                    'icon' => '<path d="M2 21c.6.5 1.2 1 2.5 1 2.5 0 2.5-2 5-2 2.6 0 2.4 2 5 2 2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1"/><path d="M19.38 20A11.6 11.6 0 0 0 21 14l-9-4-9 4c0 2.9.94 5.34 2.81 7.76"/><path d="M19 13V7a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v6"/>' // Boat
                ],
            ];
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 max-w-7xl mx-auto">
            @foreach($experiences as $index => $item)
                <div class="group flex flex-col border border-brand-green/20 bg-[#fdfdfb] hover:border-brand-orange/30 hover:shadow-lg transition-all duration-500 reveal-hidden"
                     style="transition-delay: {{ $index * 100 }}ms"
                     :class="isVisible ? 'reveal-visible' : ''">
                    
                    <div class="aspect-[4/3] overflow-hidden relative">
                        <img src="{{ $item['img'] }}" class="w-full h-full object-cover transition-transform duration-[2000ms] group-hover:scale-110" alt="{{ $item['name'] }}">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    </div>

                    <div class="p-6 flex-1 flex flex-col">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-8 h-8 flex shrink-0 items-center justify-center text-[#E67E22]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    {!! $item['icon'] !!}
                                </svg>
                            </div>
                            <h3 class="text-xl font-serif text-brand-green">{{ $item['name'] }}</h3>
                        </div>
                        <p class="text-brand-green/70 text-sm font-light leading-relaxed flex-1">{{ $item['desc'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>