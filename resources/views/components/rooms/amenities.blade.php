<section class="py-24 bg-[#f9f9f7]"
         x-data="{ isVisible: false }"
         x-intersect.once.margin.-25%.0px.-25%.0px="isVisible = true">
    <div class="container mx-auto px-6">
        
        <div class="text-center mb-16 reveal-hidden"
             :class="isVisible ? 'reveal-visible' : ''"
             style="transition-duration: 1.2s;">
            <h2 class="text-4xl font-serif text-brand-green">Room Amenities</h2>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 max-w-5xl mx-auto">
            @php
                $amenities = [
                    ['name' => 'Air Conditioning', 'icon' => '<path d="M9.59 4.59A2 2 0 1 1 11 8H2m10.59 11.41A2 2 0 1 0 14 16H2m15.73-8.27A2.5 2.5 0 1 1 19.5 12H2"/>'], // Wind
                    ['name' => 'Free WiFi', 'icon' => '<path d="M5 12.55a11 11 0 0 1 14.08 0"/><path d="M1.42 9a16 16 0 0 1 21.16 0"/><path d="M8.53 16.11a6 6 0 0 1 6.95 0"/><line x1="12" y1="20" x2="12.01" y2="20"/>'], // Wifi
                    ['name' => 'Smart TV', 'icon' => '<rect width="20" height="15" x="2" y="7" rx="2" ry="2"/><polyline points="17 2 12 7 7 2"/>'], // TV
                    ['name' => 'Luxury Bath', 'icon' => '<path d="M9 6 6.5 3.5a1.5 1.5 0 0 0-1-.5C4.683 3 4 3.683 4 4.5V17a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-5"/><line x1="10" x2="8" y1="5" y2="7"/><line x1="2" x2="22" y1="12" y2="12"/><line x1="7" x2="7" y1="19" y2="21"/><line x1="17" x2="17" y1="19" y2="21"/>'], // Bath
                    ['name' => 'Mini Bar', 'icon' => '<path d="M17 8h1a4 4 0 1 1 0 8h-1"/><path d="M3 8h14v9a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4Z"/><line x1="6" x2="6" y1="2" y2="8"/><line x1="10" x2="10" y1="2" y2="8"/><line x1="14" x2="14" y1="2" y2="8"/>'], // Coffee
                    ['name' => 'Pool Access', 'icon' => '<path d="M2 6c.6.5 1.2 1 2.5 1C7 7 7 5 9.5 5c2.6 0 2.4 2 5 2 2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1"/><path d="M2 12c.6.5 1.2 1 2.5 1 2.5 0 2.5-2 5-2 2.6 0 2.4 2 5 2 2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1"/><path d="M2 18c.6.5 1.2 1 2.5 1 2.5 0 2.5-2 5-2 2.6 0 2.4 2 5 2 2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1"/>'], // Waves
                    ['name' => 'Free Parking', 'icon' => '<path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"/><circle cx="7" cy="17" r="2"/><circle cx="17" cy="17" r="2"/>'], // Car
                    ['name' => 'Room Service', 'icon' => '<path d="M2 4v16"/><path d="M2 8h18a2 2 0 0 1 2 2v10"/><path d="M2 17h20"/><path d="M6 8v9"/>'], // Bed
                ];
            @endphp

            @foreach($amenities as $index => $item)
                <div class="text-center group reveal-hidden"
                     :class="isVisible ? 'reveal-visible' : ''"
                     style="transition-duration: 1s; transition-delay: {{ $index * 100 }}ms;">
                    
                    <div class="w-12 h-12 mx-auto mb-4 border border-brand-green/30 flex items-center justify-center text-brand-green group-hover:bg-brand-green group-hover:text-brand-light transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            {!! $item['icon'] !!}
                        </svg>
                    </div>
                    <h3 class="font-serif text-brand-green text-sm">{{ $item['name'] }}</h3>
                </div>
            @endforeach
        </div>
    </div>
</section>