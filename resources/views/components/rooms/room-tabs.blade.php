<section class="py-12 md:py-20 bg-white overflow-hidden"
         x-data="{ activeTab: '{{ $firstTab }}' }"> 

    <div class="container mx-auto px-6">
        <div class="text-center mb-12 md:mb-16 reveal-fade"
             x-data="{ isVisible: false }" 
             x-intersect.once.margin.-25%.0.-25%.0="isVisible = true"
             :class="isVisible ? 'reveal-visible' : ''"
             style="transition-duration: 1.2s;">
            <span class="text-brand-green/70 text-xs tracking-[0.2em] uppercase mb-4 block">
                Accommodations
            </span>
            <h2 class="text-3xl md:text-5xl font-serif text-brand-green mb-6">
                Choose Your Retreat
            </h2>
            <p class="text-brand-green/70 max-w-xl mx-auto font-light text-sm md:text-base">
                From cozy rooms to luxurious villas, find your perfect mountain escape
            </p>
        </div>
        <div class="flex {{ count($roomTypes) <= 3 ? 'flex-row' : 'flex-col' }} md:flex-row md:flex-wrap justify-center gap-2 md:gap-4 mb-12 md:mb-16 px-4 md:px-6">
            @foreach($roomTypes as $type)
                <button 
                    @click="activeTab = '{{ $type->slug }}'"
                    class="flex items-center justify-center px-1 py-3 md:px-6 md:py-3 transition-all duration-300 border text-[7px] sm:text-[8px] md:text-[9px] tracking-widest uppercase font-bold {{ count($roomTypes) <= 3 ? 'flex-1 md:flex-none' : 'w-full md:w-auto' }} md:min-w-[180px]"
                    :class="activeTab === '{{ $type->slug }}'
                        ? 'bg-[#1a2e2a] text-brand-light border-[#1a2e2a]'
                        : 'bg-brand-light text-brand-green/70 border-brand-green/20 hover:border-brand-green/40'">
                    
                    <span class="truncate md:whitespace-nowrap">{{ $type->name }}</span>
                    
                </button>
            @endforeach
        </div>
        <div class="relative min-h-[500px] md:min-h-[600px]">
            @foreach($roomTypes as $type)
                <div x-show="activeTab === '{{ $type->slug }}'"
                     x-transition:enter="transition ease-out duration-500"
                     x-transition:enter-start="opacity-0 translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     style="display: none;">
                     
                    @foreach($type->rooms as $room)
                        <div class="grid md:grid-cols-2 gap-8 lg:gap-16 items-center mb-12 md:mb-16 last:mb-0"
                             x-data="{ isRoomVisible: false }"
                             x-intersect.once.margin.-10%.0.-10%.0="isRoomVisible = true">

                            <div class="relative aspect-[3/2] md:aspect-[4/3] overflow-hidden group shadow-xl {{ $loop->even ? 'md:order-2 reveal-right' : 'md:order-1 reveal-left' }}"
                                 :class="isRoomVisible ? 'reveal-visible' : ''">
                                <x-image-slider :images="$room->images ?: array_filter([$room->image])" :alt="$room->name" />
                                <div class="absolute bottom-0 left-0 bg-brand-green text-[#F5F5DC] px-5 py-2 md:px-6 md:py-3 text-[9px] md:text-[10px] tracking-[0.2em] uppercase font-bold">
                                    {{ $room->tagline }}
                                </div>
                            </div>

                            <div class="flex flex-col justify-center {{ $loop->even ? 'md:order-1 reveal-left' : 'md:order-2 reveal-right' }}"
                                 :class="isRoomVisible ? 'reveal-visible' : ''">
                                <h3 class="text-2xl md:text-4xl font-serif text-brand-green mb-5 md:mb-6">
                                    {{ $room->name }}
                                </h3>
                                <p class="text-brand-green/70 leading-relaxed mb-6 md:mb-8 font-light text-sm md:text-base">
                                    {{ $room->description }}
                                </p>
                                <div class="flex gap-8 md:gap-12 mb-6 md:mb-8 border-b border-brand-green/20 pb-6 md:pb-8">
                                    <div>
                                        <span class="text-[9px] md:text-[10px] tracking-[0.2em] uppercase text-brand-green/70">
                                            Capacity
                                        </span>
                                        <p class="font-serif text-brand-green mt-1">
                                            {{ $room->capacity }}
                                        </p>
                                    </div>
                                    <div>
                                        <span class="text-[9px] md:text-[10px] tracking-[0.2em] uppercase text-brand-green/70">
                                            Size
                                        </span>
                                        <p class="font-serif text-brand-green mt-1">
                                            {{ $room->size }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex flex-wrap gap-2 md:gap-3 mb-8 md:mb-10">
                                    @foreach($room->features as $feature)
                                        <span class="text-[9px] md:text-[10px] tracking-[0.1em] uppercase border border-brand-green/20 text-brand-green/70 px-3 py-2">
                                            {{ $feature->name }}
                                        </span>
                                    @endforeach
                                </div>
                                <div class="flex flex-wrap gap-3">
                                    {{-- Carries the room type through, so the contact form opens
                                         with Room Booking + this room already selected. --}}
                                    <a href="{{ route('contact', ['type' => \App\Models\Enquiry::TYPE_ROOM, 'room_type' => $type->name]) }}"
                                       class="inline-flex items-center gap-2 bg-brand-green text-brand-light hover:bg-brand-orange px-6 md:px-8 py-3 md:py-4 text-[9px] md:text-[10px] tracking-[0.2em] uppercase font-bold transition-colors">
                                        Make an Enquiry
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @if($type->rooms->isEmpty())
                        <div class="text-center py-16 md:py-20 text-brand-green/50 font-light italic reveal-fade"
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
