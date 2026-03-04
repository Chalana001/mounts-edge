<section class="py-24 md:py-32 bg-[#f9f9f7]" 
         x-data="{ isVisible: false }" 
         x-intersect.once.margin.-25%.0.-25%.0="isVisible = true">
    
    <div class="container mx-auto px-6">
        <div class="text-center mb-16 reveal-hidden" :class="isVisible ? 'reveal-visible' : ''">
            <span class="text-brand-green/70 text-xs tracking-[0.2em] uppercase mb-4 block">Explore the Region</span>
            <h2 class="text-4xl md:text-5xl font-serif text-brand-green mb-6">Nearby Attractions</h2>
            <p class="text-brand-green/70 max-w-xl mx-auto font-light leading-relaxed">
                Discover the sacred and scenic wonders surrounding our retreat, each just a short journey away.
            </p>
        </div>

        @php
            $highlights = [
                [
                    'name' => 'Historical Mahiyangana Temple', 
                    'dist' => '5 min drive', 
                    'desc' => 'One of the most sacred Buddhist sites in Sri Lanka, where the Buddha first visited the island.',
                    'img' => 'storage/experiences/nearby-highlights/mahiyangana-temple.jpg'
                ],
                [
                    'name' => 'Sorabora Wewa', 
                    'dist' => '15 min drive', 
                    'desc' => 'An ancient reservoir built during the era of King Dutugemunu, famous for its natural rock sluice.',
                    'img' => 'storage/experiences/nearby-highlights/sorabora-wewa.jfif'
                ],
                [
                    'name' => 'Rathna Ella', 
                    'dist' => '45 min drive', 
                    'desc' => 'A breathtaking and wide waterfall hidden within the lush green forests of Hasalaka.',
                    'img' => 'storage/experiences/nearby-highlights/rathna-ella.jfif'
                ],
                [
                    'name' => '18 Bends (Dahata Wanguwa)', 
                    'dist' => '30 min drive', 
                    'desc' => 'The famous winding road offering breathtaking panoramic views of the Mahiyangana valley.',
                    'img' => 'storage/experiences/nearby-highlights/18-bends.jpg'
                ],
                [
                    'name' => 'Dambana (Vedda People)', 
                    'dist' => '40 min drive', 
                    'desc' => 'Meet the indigenous people of Sri Lanka and experience their traditional way of life and culture.',
                    'img' => 'storage/experiences/nearby-highlights/dambana.jpg'
                ],
                [
                    'name' => 'Seetha Kotuwa', 
                    'dist' => '20 min drive', 
                    'desc' => 'A mythological and archaeological site deeply connected to the ancient Ramayana legend.',
                    'img' => 'storage/experiences/nearby-highlights/seetha-kotuwa.jpg'
                ],
                [
                    'name' => 'Dunhinda Fall', 
                    'dist' => '1.5 hours drive', 
                    'desc' => 'One of Sri Lanka\'s most iconic and beautiful waterfalls, creating a smoky mist as it cascades.',
                    'img' => 'storage/experiences/nearby-highlights/dunhinda-fall.jpg'
                ],
                [
                    'name' => 'Maha Oya Hot Springs', 
                    'dist' => '1 hour drive', 
                    'desc' => 'Natural thermal hot springs renowned for their therapeutic and relaxing properties.',
                    'img' => 'storage/experiences/nearby-highlights/maha-oya.jpg'
                ],
                [
                    'name' => 'Mawaragala Forest Monastery', 
                    'dist' => '30 min drive', 
                    'desc' => 'A serene and ancient forest hermitage offering peace and deep spiritual tranquility.',
                    'img' => 'storage/experiences/nearby-highlights/mawaragala-forest.jfif'
                ],

                [
                    'name' => 'Victoria Dam', 
                    'dist' => '1.5 hours drive', 
                    'desc' => 'The tallest dam in Sri Lanka, featuring a stunning double-curvature arch design and scenic views.',
                    'img' => 'storage/experiences/nearby-highlights/victoria-dam.jpg'
                ],
                [
                    'name' => 'Randenigala Dam', 
                    'dist' => '1 hour drive', 
                    'desc' => 'A massive scenic reservoir surrounded by beautiful mountains and wildlife-rich sanctuaries.',
                    'img' => 'storage/experiences/nearby-highlights/randenigala-dam.jpg'
                ],
                [
                    'name' => 'Meemure', 
                    'dist' => '2 hours drive', 
                    'desc' => 'One of the most remote and picturesque traditional villages hidden deep in the Knuckles range.',
                    'img' => 'storage/experiences/nearby-highlights/meemure.jpg'
                ],
                [
                    'name' => 'Riverston', 
                    'dist' => '2 hours drive', 
                    'desc' => 'A spectacular windy gap in the Knuckles mountain range offering sweeping panoramic vistas.',
                    'img' => 'storage/experiences/nearby-highlights/riverston.jpg'
                ],
                [
                    'name' => 'Wasgamuwa National Park', 
                    'dist' => '1 hour drive', 
                    'desc' => 'A thrilling wildlife sanctuary perfect for spotting wild elephants and diverse bird species.',
                    'img' => 'storage/experiences/nearby-highlights/wasgamuwa.jpg'
                ],
                [
                    'name' => 'Maduru Oya National Park', 
                    'dist' => '1.5 hours drive', 
                    'desc' => 'A beautiful national park rich in wildlife, indigenous culture, and ancient reservoir ruins.',
                    'img' => 'storage/experiences/nearby-highlights/maduru-oya.jpg'
                ]
            ];
        @endphp

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8 max-w-7xl mx-auto">
            @foreach($highlights as $index => $place)
                <div class="group bg-white border border-brand-green/20 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500 reveal-hidden"
                     style="transition-delay: {{ $index * 150 }}ms"
                     :class="isVisible ? 'reveal-visible' : ''">
                    
                    <div class="aspect-[16/10] overflow-hidden">
                        <img src="{{ $place['img'] }}" alt="{{ $place['name'] }}" 
                             class="w-full h-full object-cover transition-transform duration-[2000ms] group-hover:scale-110">
                    </div>

                    <div class="p-8">
                        <div class="flex items-center gap-2 mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-brand-orange">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
                            </svg>
                            <span class="text-[9px] tracking-[0.2em] uppercase text-brand-orange font-bold">
                                {{ $place['dist'] }}
                            </span>
                        </div>
                        
                            <h3 class="font-serif text-brand-green text-xl mb-3 group-hover:text-brand-orange transition-colors duration-300">
                            {{ $place['name'] }}
                        </h3>
                        
                        <p class="text-brand-green/70 text-xs font-light leading-relaxed">
                            {{ $place['desc'] }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>