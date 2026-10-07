<section class="py-12 md:py-20 bg-white overflow-hidden"
         x-data="{ tabs: @js($roomTypes->pluck('slug')), activeTab: '{{ $firstTab }}',

        // Arrow keys walk the tablist, which is what a screen-reader user expects
        // once these announce themselves as tabs.
        moveTab(direction, event) {
            const at = this.tabs.indexOf(this.activeTab);
            const to = direction === 'first' ? 0
                : direction === 'last' ? this.tabs.length - 1
                : (at + direction + this.tabs.length) % this.tabs.length;

            this.activeTab = this.tabs[to];
            this.$nextTick(() => event.target.closest('[role=tablist]')?.querySelectorAll('[role=tab]')[to]?.focus());
        } }" >

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
                Deluxe single, double, triple and family rooms, plus a Family Suite — in Gurulupotha, near Hasalaka and Mahiyangana. Find your mountain escape
            </p>
        </div>
        <div role="tablist" aria-label="Room types" class="flex {{ count($roomTypes) <= 3 ? 'flex-row' : 'flex-col' }} md:flex-row md:flex-wrap justify-center gap-2 md:gap-4 mb-12 md:mb-16 px-4 md:px-6">
            @foreach($roomTypes as $type)
                <button type="button"
                    role="tab"
                    id="room-tab-{{ $type->slug }}"
                    aria-controls="room-panel-{{ $type->slug }}"
                    :aria-selected="activeTab === '{{ $type->slug }}' ? 'true' : 'false'"
                    :tabindex="activeTab === '{{ $type->slug }}' ? 0 : -1"
                    @click="activeTab = '{{ $type->slug }}'"
                    @keydown.right.prevent="moveTab(1, $event)"
                    @keydown.left.prevent="moveTab(-1, $event)"
                    @keydown.home.prevent="moveTab('first', $event)"
                    @keydown.end.prevent="moveTab('last', $event)"
                    class="flex items-center justify-center px-2 py-3 md:px-6 md:py-3 transition-all duration-300 border text-[11px] tracking-widest uppercase font-bold focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-orange focus-visible:ring-offset-2 {{ count($roomTypes) <= 3 ? 'flex-1 md:flex-none' : 'w-full md:w-auto' }} md:min-w-[180px]"
                    :class="activeTab === '{{ $type->slug }}'
                        ? 'bg-brand-green text-brand-light border-brand-green'
                        : 'bg-brand-light text-brand-green/70 border-brand-green/20 hover:border-brand-green/40'">
                    
                    <span class="truncate md:whitespace-nowrap">{{ $type->name }}</span>
                    
                </button>
            @endforeach
        </div>
        <div class="relative min-h-[500px] md:min-h-[600px]">
            @foreach($roomTypes as $type)
                <div x-show="activeTab === '{{ $type->slug }}'"
                     id="room-panel-{{ $type->slug }}"
                     role="tabpanel"
                     aria-labelledby="room-tab-{{ $type->slug }}"
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
                                <div class="absolute bottom-0 left-0 bg-brand-green text-brand-cream px-5 py-2 md:px-6 md:py-3 text-[11px] md:text-[11px] tracking-[0.2em] uppercase font-bold">
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
                                        <span class="text-[11px] md:text-[11px] tracking-[0.2em] uppercase text-brand-green/70">
                                            Capacity
                                        </span>
                                        <p class="font-serif text-brand-green mt-1">
                                            {{ $room->capacity }}
                                        </p>
                                    </div>
                                    <div>
                                        <span class="text-[11px] md:text-[11px] tracking-[0.2em] uppercase text-brand-green/70">
                                            Size
                                        </span>
                                        <p class="font-serif text-brand-green mt-1">
                                            {{ $room->size }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex flex-wrap gap-2 md:gap-3 mb-8 md:mb-10">
                                    @foreach($room->features as $feature)
                                        <span class="text-[11px] md:text-[11px] tracking-[0.1em] uppercase border border-brand-green/20 text-brand-green/70 px-3 py-2">
                                            {{ $feature->name }}
                                        </span>
                                    @endforeach
                                </div>
                                <div class="flex flex-wrap gap-3">
                                    <a href="{{ route('contact', ['type' => \App\Models\Enquiry::TYPE_ROOM, 'room_type' => $type->name]) }}"
                                       class="inline-flex items-center gap-2 bg-brand-green text-brand-light hover:bg-brand-hover px-6 md:px-8 py-3 md:py-4 text-[11px] md:text-[11px] tracking-[0.2em] uppercase font-bold transition-colors">
                                        Make an Enquiry
                                    </a>
                                    <a href="{{ route('contact', ['type' => \App\Models\Enquiry::TYPE_ROOM]) }}"
                                       class="inline-flex items-center gap-2 border border-brand-green/30 text-brand-green hover:border-brand-ember hover:text-brand-ember px-6 md:px-8 py-3 md:py-4 text-[11px] md:text-[11px] tracking-[0.2em] uppercase font-bold transition-colors">
                                        Ask About All Rooms
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
