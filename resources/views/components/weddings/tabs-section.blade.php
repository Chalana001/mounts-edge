<section class="py-24 md:py-32 bg-white" x-data="{ activeTab: 'hall' }">
    <div class="container mx-auto px-6">

    @props(['tabs'])

        <div class="flex flex-wrap justify-center gap-2 md:gap-4 mb-16 px-6 relative z-20">
            @foreach($tabs as $key => $tab)
                <button @click="activeTab = '{{ $key }}'"
                        class="flex items-center justify-center gap-3 px-6 py-4 transition-all duration-300 border text-[10px] tracking-widest uppercase font-bold w-full sm:w-[220px]"
                        :class="activeTab === '{{ $key }}' ? 'bg-[#1a2e2a] text-brand-light border-[#1a2e2a]' : 'bg-brand-light text-[#1a2e2a]/60 border-brand-green/20 hover:border-[#1a2e2a] hover:text-[#1a2e2a]'">
                    
                    <span class="flex-shrink-0">{!! $tab['icon'] !!}</span>

                    <span class="truncate">{{ $tab['label'] }}</span>
                </button>
            @endforeach
        </div>

        <div class="min-h-[350px] md:min-h-[400px] transition-all duration-500">
            @foreach($tabs as $key => $tab)
                <div x-show="activeTab === '{{ $key }}'"
                     x-transition:enter="transition ease-out duration-500"
                     x-transition:enter-start="opacity-0 translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     style="display: none;">

                    @if($tab['type'] === 'multi-split')
                        <div class="space-y-32">
                            @foreach($tab['items'] as $item)
                                <div class="grid md:grid-cols-2 gap-16 lg:gap-24 items-center reveal-hidden"
                                     x-data="{ isSplitVisible: false }" 
                                     x-intersect.once.margin.-10%.0.-10%.0="isSplitVisible = true"
                                     :class="isSplitVisible ? 'reveal-visible' : ''"
                                     style="transition-duration: 1.5s;">
                                     
                                    <div class="relative aspect-[4/3] w-full overflow-hidden group shadow-xl {{ $loop->even ? 'md:order-2' : 'md:order-1' }}">
                                        <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" 
                                             class="w-full h-full object-cover transition-transform duration-[2000ms] group-hover:scale-110">
                                        <div class="absolute bottom-0 left-0 bg-brand-green text-[#F5F5DC] px-6 py-3 text-[10px] tracking-[0.2em] uppercase font-bold">
                                            {{ $item['tagline'] }}
                                        </div>
                                    </div>

                                    <div class="flex flex-col justify-center w-full {{ $loop->even ? 'md:order-1' : 'md:order-2' }}">
                                        <h3 class="text-3xl md:text-4xl font-serif text-brand-green mb-6">{{ $item['title'] }}</h3>
                                        <p class="text-brand-green/70 leading-relaxed mb-8 font-light">{{ $item['desc'] }}</p>
                                        
                                        @if(isset($item['details']))
                                            <div class="grid grid-cols-2 gap-6 mb-8">
                                                @foreach($item['details'] as $detail)
                                                    <div>
                                                        <span class="text-[10px] tracking-[0.15em] uppercase text-brand-green/70">{{ $detail['label'] }}</span>
                                                        <p class="font-serif text-brand-green mt-1">{{ $detail['value'] }}</p>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif

                                        @if(isset($item['tags']))
                                            <div class="flex flex-wrap gap-3">
                                                @foreach($item['tags'] as $tag)
                                                    <span class="text-[10px] tracking-[0.1em] uppercase border border-brand-green/20 text-brand-green/70 px-3 py-2">
                                                        {{ $tag }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    @elseif($tab['type'] === 'split')
                        <div class="grid md:grid-cols-2 gap-16 lg:gap-24 items-center reveal-hidden"
                            x-data="{ isSplitVisible: false }" 
                            x-intersect.once.margin.-10%.0.-10%.0="isSplitVisible = true"
                            :class="isSplitVisible ? 'reveal-visible' : ''"
                            style="transition-duration: 1.5s;">
                            
                            <div class="relative aspect-[4/3] w-full overflow-hidden group shadow-xl md:order-1">
                                <img src="{{ $tab['image'] }}" alt="{{ $tab['title'] }}" 
                                    class="w-full h-full object-cover transition-transform duration-[2000ms] group-hover:scale-110">
                                <div class="absolute bottom-0 left-0 bg-brand-green text-[#F5F5DC] px-6 py-3 text-[10px] tracking-[0.2em] uppercase font-bold">
                                    {{ $tab['tagline'] }}
                                </div>
                            </div>

                            <div class="flex flex-col justify-center w-full md:order-2">
                                <h3 class="text-3xl md:text-4xl font-serif text-brand-green mb-6">{{ $tab['title'] }}</h3>
                                <p class="text-brand-green/70 leading-relaxed mb-8 font-light">{{ $tab['desc'] }}</p>
                                
                                @if(isset($tab['details']))
                                    <div class="grid grid-cols-2 gap-6 mb-8">
                                        @foreach($tab['details'] as $detail)
                                            <div>
                                                <span class="text-[10px] tracking-[0.15em] uppercase text-brand-green/70">{{ $detail['label'] }}</span>
                                                <p class="font-serif text-brand-green mt-1">{{ $detail['value'] }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                @if(isset($tab['list_items']))
                                    <div class="mb-8 pl-4 border-l-2 border-brand-green/20">
                                        <h4 class="text-xs tracking-[0.15em] uppercase text-brand-green/70 mb-4">{{ $tab['list_title'] ?? 'Options' }}</h4>
                                        <ul class="space-y-2">
                                            @foreach($tab['list_items'] as $item)
                                                <li class="text-sm text-brand-green/70 font-light">{{ $item }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                @if(isset($tab['tags']))
                                    <div class="flex flex-wrap gap-3">
                                        @foreach($tab['tags'] as $tag)
                                            <span class="text-[10px] tracking-[0.1em] uppercase border border-brand-green/20 text-brand-green/70 px-3 py-2">
                                                {{ $tag }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>

@elseif($tab['type'] === 'grid')
    
    <div class="text-center mb-12 reveal-hidden"
         x-data="{ isGridHeadingVisible: false }" 
         x-intersect.once="isGridHeadingVisible = true"
         :class="isGridHeadingVisible ? 'reveal-visible' : ''"
         style="transition-duration: 1.2s;">
        <h3 class="text-3xl md:text-4xl font-serif text-brand-green mb-4">{{ $tab['title'] }}</h3>
        <p class="text-brand-green/70 max-w-xl mx-auto font-light">{{ $tab['desc'] }}</p>
    </div>
    
    <div class="reveal-hidden flex overflow-x-auto snap-x snap-mandatory gap-4 pt-4 pb-8 px-4 md:px-0 md:grid md:grid-cols-4 md:gap-6 md:pb-0 md:pt-4 md:overflow-visible"
        x-data="{ isGridVisible: false }" 
        x-intersect.once.margin.-10%.0.-10%.0="isGridVisible = true"
        :class="isGridVisible ? 'reveal-visible' : ''"
        style="transition-duration: 1.5s;">
        
        @foreach($tab['items'] as $pkg)
            <div x-data="{ expanded: false }" class="relative border p-6 md:p-8 transition-all duration-300 hover:shadow-lg flex-none w-[80vw] max-w-[320px] snap-center md:max-w-none md:w-full {{ $pkg['popular'] ? 'border-brand-green' : 'border-brand-green/20' }}">
                
                @if($pkg['popular'])
                    <div class="absolute -top-3 left-1/2 -translate-x-1/2 bg-[#1a2e2a] text-white text-[10px] tracking-[0.1em] uppercase px-4 py-1 whitespace-nowrap z-10">
                        Most Popular
                    </div>
                @endif
                
                <h4 class="text-2xl font-serif text-brand-green mb-2">{{ $pkg['name'] }}</h4>
                <p class="text-[10px] tracking-[0.15em] uppercase text-brand-green/70 mb-4 border-b border-brand-green/20 pb-4">{{ $pkg['guests'] }}</p>
                
                <button @click="expanded = !expanded" 
                        class="flex w-full items-center justify-between py-2 text-xs font-bold uppercase tracking-widest text-brand-green hover:text-[#1a2e2a] transition-colors duration-200 cursor-pointer focus:outline-none">
                    <span x-text="expanded ? 'Hide Menu' : 'View Menu'"></span>
                    <svg :class="expanded ? 'rotate-180' : ''" class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                
                <div x-show="expanded" 
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-[-10px]"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 translate-y-[-10px]"
                    class="space-y-6 mt-4 pt-4 border-t border-brand-green/10"
                    style="display: none;">
                    
                    @foreach($pkg['includes'] as $section)
                        <div>
                            <div class="flex items-baseline justify-between mb-2">
                                <h5 class="font-bold text-sm text-[#1a2e2a] uppercase tracking-wider">{{ $section['title'] }}</h5>
                                @if($section['rule'])
                                    <span class="text-[9px] bg-[#E67E22]/10 text-[#E67E22] px-2 py-1 font-bold tracking-widest uppercase whitespace-nowrap">
                                        {{ $section['rule'] }}
                                    </span>
                                @endif
                            </div>
                            <ul class="text-sm text-brand-green/70 font-light leading-relaxed">
                                <li>{{ implode(', ', $section['items']) }}</li>
                            </ul>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
@endif

                </div>
            @endforeach
        </div>
    </div>
</section>