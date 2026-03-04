<section class="py-24 md:py-32 bg-white" 
         x-data="{ activeTab: '{{ $firstTab }}' }"> 
    <div class="container mx-auto px-6">
        
        <div class="text-center mb-16 reveal-hidden"
             x-data="{ isVisible: false }" 
             x-intersect.once.margin.-25%.0.-25%.0="isVisible = true"
             :class="isVisible ? 'reveal-visible' : ''"
             style="transition-duration: 1.2s;">
            <span class="text-brand-green/70 text-xs tracking-[0.2em] uppercase mb-4 block">Accommodations</span>
            <h2 class="text-4xl md:text-5xl font-serif text-brand-green mb-6">Choose Your Retreat</h2>
            <p class="text-brand-green/70 max-w-xl mx-auto font-light">
                From cozy rooms to luxurious villas, find your perfect mountain escape
            </p>
        </div>

        <div class="flex flex-wrap justify-center gap-2 md:gap-4 mb-16 px-6">
            @foreach($roomTypes as $type)
                <button @click="activeTab = '{{ $type->slug }}'"
                        class="flex items-center justify-center gap-3 px-6 py-4 transition-all duration-300 border text-[10px] tracking-widest uppercase font-bold w-full sm:w-[220px]"
                        :class="activeTab === '{{ $type->slug }}' ? 'bg-[#1a2e2a] text-brand-light border-[#1a2e2a]' : 'bg-brand-light text-brand-green/70 border-brand-green/20 hover:border-brand-green/40'">

                    <span class="truncate">{{ $type->name }}</span>
                </button>
            @endforeach
        </div>

        <div class="relative min-h-[600px]">
            @foreach($roomTypes as $type)
                <div x-show="activeTab === '{{ $type->slug }}'"
                     x-transition:enter="transition ease-out duration-500"
                     x-transition:enter-start="opacity-0 translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     style="display: none;">
                     
                    @foreach($type->rooms as $room)
                        <div class="grid md:grid-cols-2 gap-16 lg:gap-24 items-center mb-24 last:mb-0 reveal-hidden"
                            x-data="{ isRoomVisible: false }" 
                            x-intersect.once.margin.-10%.0.-10%.0="isRoomVisible = true"
                            :class="isRoomVisible ? 'reveal-visible' : ''"
                            style="transition-duration: 1.5s;">
                            
                            <div class="relative aspect-[4/3] overflow-hidden group shadow-xl {{ $loop->even ? 'md:order-2' : 'md:order-1' }}">
                                <img src="{{ $room->image }}" alt="{{ $room->name }}" 
                                    class="w-full h-full object-cover transition-transform duration-[2000ms] group-hover:scale-110">
                                <div class="absolute bottom-0 left-0 bg-brand-green text-[#F5F5DC] px-6 py-3 text-[10px] tracking-[0.2em] uppercase font-bold">
                                    {{ $room->tagline }}
                                </div>
                            </div>

                            <div class="flex flex-col justify-center {{ $loop->even ? 'md:order-1' : 'md:order-2' }}">
                                <h3 class="text-3xl md:text-4xl font-serif text-brand-green mb-6">{{ $room->name }}</h3>
                                <p class="text-brand-green/70 leading-relaxed mb-8 font-light">{{ $room->description }}</p>
                                
                                <div class="flex gap-12 mb-8 border-b border-brand-green/20 pb-8">
                                    <div>
                                        <span class="text-[10px] tracking-[0.2em] uppercase text-brand-green/70">Capacity</span>
                                        <p class="font-serif text-brand-green mt-1">{{ $room->capacity }}</p>
                                    </div>
                                    <div>
                                        <span class="text-[10px] tracking-[0.2em] uppercase text-brand-green/70">Size</span>
                                        <p class="font-serif text-brand-green mt-1">{{ $room->size }}</p>
                                    </div>
                                </div>

                                <div class="flex flex-wrap gap-3 mb-10">
                                    @foreach($room->features as $feature)
                                        <span class="text-[10px] tracking-[0.1em] uppercase border border-brand-green/20 text-brand-green/70 px-3 py-2">
                                            {{ $feature->name }}
                                        </span>
                                    @endforeach
                                </div>

                                <div>
                                    <a href="#"
                                    x-data 
                                    @click.prevent="
                                        fetch('/notify-whatsapp', {
                                            method: 'POST',
                                            headers: {
                                                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content'),
                                                'Accept': 'application/json'
                                            }
                                        });
                                        window.open('https://wa.me/94704589764?text=Hello%20Mounts%20Edge%20Regency!%20I%20would%20like%20to%20book%20room.', '_blank');
                                    "
                                    class="inline-flex items-center gap-2 bg-brand-green text-brand-light hover:bg-brand-orange px-8 py-4 text-[10px] tracking-[0.2em] uppercase font-bold transition-colors">
                                        Book on Whatsapp
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    
                    @if($type->rooms->isEmpty())
                        <div class="text-center py-20 text-brand-green/50 font-light italic reveal-hidden"
                             x-data="{ isEmptyVisible: false }" 
                             x-intersect.once="isEmptyVisible = true"
                             :class="isEmptyVisible ? 'reveal-visible' : ''"
                             style="transition-duration: 1s;">
                            No rooms available in this category yet.
                        </div>
                    @endif

                </div>
            @endforeach
        </div>

    </div>
</section>