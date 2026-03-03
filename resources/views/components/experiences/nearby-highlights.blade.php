<section class="py-24 md:py-32 bg-[#f9f9f7]" 
         x-data="{ isVisible: false }" 
         x-intersect.once.margin.-15%.0.-15%.0="isVisible = true">
    
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
                    'img' => 'https://www.lovesrilanka.org/wp-content/uploads/2020/04/Sudharmalaya-Temple-800.jpg'
                ],
                [
                    'name' => 'Sorabora Wewa', 
                    'dist' => '15 min drive', 
                    'desc' => 'An ancient reservoir built during the era of King Dutugemunu, famous for its natural rock sluice.',
                    'img' => 'https://scontent-bom5-2.xx.fbcdn.net/v/t39.30808-6/474683153_632863846092665_3694245725688750947_n.jpg?_nc_cat=104&ccb=1-7&_nc_sid=13d280&_nc_eui2=AeGp7jjM2wxoD2-8K3mVNuebT9vM-yNddQFP28z7I111ATJaQa9CLdErsHfY_XamY1wm4F4jA5uTN5sVdabO9oKY&_nc_ohc=A0fhYDi878QQ7kNvwFTw9xu&_nc_oc=Adn1fU1GNltvJO-vsRDSRzJ0UVzC4CggM3iIFxXLBpWAuZILQ8MsQ2oGaEyxZtG2Avc&_nc_zt=23&_nc_ht=scontent-bom5-2.xx&_nc_gid=OKERgwJkwX6rqvc5jcxZlA&oh=00_AfuJ0ZbnIx5pBgEhn4UcEScZ3dSqY9cDAuFB9VeTvM4oYQ&oe=699CFDEC'
                ],
                [
                    'name' => 'Rathna Ella', 
                    'dist' => '45 min drive', 
                    'desc' => 'A breathtaking and wide waterfall hidden within the lush green forests of Hasalaka.',
                    'img' => 'https://scontent-bom5-1.xx.fbcdn.net/v/t1.6435-9/131443989_1697193307131654_5994307991670950422_n.jpg?_nc_cat=110&ccb=1-7&_nc_sid=7b2446&_nc_eui2=AeHoeg_qU6dfs66gA1VEtlxaS2eCh8CofkxLZ4KHwKh-TB3NX13cE4EVQUlFdFCiKbsSNu1_zbKHPPVoKps2P3uz&_nc_ohc=8-b4PFMEXuAQ7kNvwHTJlR8&_nc_oc=AdkC9PFZLPXbQ_We217iqXyU2yHLmk8-NAQVg6LtmU8zoMu9yDAgGfD_cxoUsvrYroU&_nc_zt=23&_nc_ht=scontent-bom5-1.xx&_nc_gid=1F5KWbYl36o_Unhkifictg&oh=00_AfvwrrsyIWZYREW5sT8chvWkU-_BrPnuBzFLmMoRUEt-_g&oe=69BE82D4'
                ],
                [
                    'name' => '18 Bends (Dahata Wanguwa)', 
                    'dist' => '30 min drive', 
                    'desc' => 'The famous winding road offering breathtaking panoramic views of the Mahiyangana valley.',
                    'img' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ6Ma1g-v0xK2H9xUUSU8LqAqFPHdlXboCL2A&s'
                ],
                [
                    'name' => 'Dambana (Vedda People)', 
                    'dist' => '40 min drive', 
                    'desc' => 'Meet the indigenous people of Sri Lanka and experience their traditional way of life and culture.',
                    'img' => 'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=600&q=80'
                ],
                [
                    'name' => 'Seetha Kotuwa', 
                    'dist' => '20 min drive', 
                    'desc' => 'A mythological and archaeological site deeply connected to the ancient Ramayana legend.',
                    'img' => 'https://i.pinimg.com/736x/2f/04/80/2f048050ff3bcffa7786401cbc18aefe.jpg'
                ],
                [
                    'name' => 'Dunhinda Fall', 
                    'dist' => '1.5 hours drive', 
                    'desc' => 'One of Sri Lanka\'s most iconic and beautiful waterfalls, creating a smoky mist as it cascades.',
                    'img' => 'https://www.thingstodosrilanka.com/wp-content/uploads/2025/07/Dunhinda-Falls-2.jpg'
                ],
                [
                    'name' => 'Maha Oya Hot Springs', 
                    'dist' => '1 hour drive', 
                    'desc' => 'Natural thermal hot springs renowned for their therapeutic and relaxing properties.',
                    'img' => 'https://www.attractionsinsrilanka.com/wp-content/uploads/2023/05/Maha-Oya-Hot-Water-Springs.jpg'
                ],
                [
                    'name' => 'Mawaragala Forest Monastery', 
                    'dist' => '30 min drive', 
                    'desc' => 'A serene and ancient forest hermitage offering peace and deep spiritual tranquility.',
                    'img' => 'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=600&q=80'
                ],

                [
                    'name' => 'Victoria Dam', 
                    'dist' => '1.5 hours drive', 
                    'desc' => 'The tallest dam in Sri Lanka, featuring a stunning double-curvature arch design and scenic views.',
                    'img' => 'https://scontent-bom5-1.xx.fbcdn.net/v/t39.30808-6/483980184_4150319665295404_5753091995497391204_n.jpg?_nc_cat=109&ccb=1-7&_nc_sid=13d280&_nc_eui2=AeEaoWl81gwpUEJTGZL23Hu6QXoiBDax97RBeiIENrH3tECCaGP1yn249MGOlN9eRv5XgdwfKjrpy7GMUJJMsBIp&_nc_ohc=Tx65m0eGZmIQ7kNvwHtQMMu&_nc_oc=AdlPcmQwZAeZ14uk3SrH1nWlNxSa7KSkErh7A0rkWlRWzy485SmDasvjkRFvYxJLJ7g&_nc_zt=23&_nc_ht=scontent-bom5-1.xx&_nc_gid=iHiWZTM-ZamgOfEMq0FdGQ&oh=00_Afvb5pljWgvoZKLAA_Oxm3Y7h2ggbxavmJWnc3cVQxy_-w&oe=699CDEEC'
                ],
                [
                    'name' => 'Randenigala Dam', 
                    'dist' => '1 hour drive', 
                    'desc' => 'A massive scenic reservoir surrounded by beautiful mountains and wildlife-rich sanctuaries.',
                    'img' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSeG2GBLgyhJ0gjvC6E0xr63QJ7SJkFE6TQZQ&s'
                ],
                [
                    'name' => 'Meemure', 
                    'dist' => '2 hours drive', 
                    'desc' => 'One of the most remote and picturesque traditional villages hidden deep in the Knuckles range.',
                    'img' => 'https://images.unsplash.com/photo-1432405972618-c60b0225b8f9?w=600&q=80'
                ],
                [
                    'name' => 'Riverston', 
                    'dist' => '2 hours drive', 
                    'desc' => 'A spectacular windy gap in the Knuckles mountain range offering sweeping panoramic vistas.',
                    'img' => 'https://thehiddensrilanka.com/wp-content/uploads/2024/08/riverston-11.jpg'
                ],
                [
                    'name' => 'Wasgamuwa National Park', 
                    'dist' => '1 hour drive', 
                    'desc' => 'A thrilling wildlife sanctuary perfect for spotting wild elephants and diverse bird species.',
                    'img' => 'https://static.wixstatic.com/media/ba255b_daf428b2ab814f94b85b3fc4d4a28f97~mv2.jpg/v1/fill/w_640,h_440,al_c,q_80,usm_0.66_1.00_0.01,enc_auto/ba255b_daf428b2ab814f94b85b3fc4d4a28f97~mv2.jpg'
                ],
                [
                    'name' => 'Maduru Oya National Park', 
                    'dist' => '1.5 hours drive', 
                    'desc' => 'A beautiful national park rich in wildlife, indigenous culture, and ancient reservoir ruins.',
                    'img' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRac99QdIPdaAai0oiuNbrhHB-F-FvYQM9rMQ&s'
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