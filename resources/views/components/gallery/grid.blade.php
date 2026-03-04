<div x-data="{ activeTab: 'All', selectedImg: null }" class="py-24 bg-[#FAF9F6] min-h-screen">
    
    <div class="text-center mb-12 px-6 reveal-hidden"
         x-data="{ isHeaderVisible: false }"
         x-intersect.once.margin.-25%.0.-25%.0="isHeaderVisible = true"
         :class="isHeaderVisible ? 'reveal-visible' : ''"
         style="transition-duration: 1.2s;">
        <h2 class="text-4xl md:text-5xl font-serif text-[#1a2e2a] mb-4">Our Gallery</h2>
        <p class="text-[#1a2e2a]/70 font-light max-w-2xl mx-auto">Explore the beauty, luxury, and unforgettable moments at Mounts Edge Regency.</p>
    </div>

    <div class="flex flex-wrap justify-center gap-2 md:gap-4 mb-16 px-6 relative z-20 reveal-hidden"
         x-data="{ isTabsVisible: false }"
         x-intersect.once.margin.-10%.0.-10%.0="isTabsVisible = true"
         :class="isTabsVisible ? 'reveal-visible' : ''"
         style="transition-duration: 1.2s; transition-delay: 200ms;">
         
        <button @click="activeTab = 'All'"
                class="px-6 py-3 text-[10px] tracking-widest uppercase font-bold border transition-all duration-300 shadow-sm"
                :class="activeTab === 'All' ? 'bg-[#1a2e2a] text-[#FAF9F6] border-[#1a2e2a]' : 'bg-white text-[#1a2e2a]/70 border-[#1a2e2a]/20 hover:border-[#1a2e2a] hover:text-[#1a2e2a]'">
            All
        </button>

        @foreach($categories as $category)
            <button @click="activeTab = '{{ $category->name }}'"
                    class="px-6 py-3 text-[10px] tracking-widest uppercase font-bold border transition-all duration-300 shadow-sm"
                    :class="activeTab === '{{ $category->name }}' ? 'bg-[#1a2e2a] text-[#FAF9F6] border-[#1a2e2a]' : 'bg-white text-[#1a2e2a]/70 border-[#1a2e2a]/20 hover:border-[#1a2e2a] hover:text-[#1a2e2a]'">
                {{ $category->name }}
            </button>
        @endforeach
    </div>

    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8 reveal-hidden"
             x-data="{ isGridVisible: false }"
             x-intersect.once.margin.-10%.0.-10%.0="isGridVisible = true"
             :class="isGridVisible ? 'reveal-visible' : ''"
             style="transition-duration: 1.5s; transition-delay: 400ms;">
             
            @forelse($galleryItems as $item)
                <div x-show="activeTab === 'All' || activeTab === '{{ $item->category->name ?? 'Uncategorized' }}'"
                     x-transition:enter="transition ease-out duration-500"
                     x-transition:enter-start="opacity-0 translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     @click="selectedImg = '{{ asset($item->image) }}'"
                     class="group cursor-pointer">
                    
                    <div class="aspect-square overflow-hidden bg-white shadow-sm border border-gray-200 rounded-sm relative">
                        <img src="{{ asset($item->image) }}" alt="{{ $item->description }}" 
                             class="w-full h-full object-cover transition-transform duration-[1500ms] group-hover:scale-110">
                        
                        <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-center justify-center">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                        </div>
                    </div>
                    
                    <div class="mt-4 text-center">
                        <span class="text-[9px] tracking-[0.2em] uppercase text-[#E67E22] font-bold block mb-1">
                            {{ $item->category->name ?? 'Uncategorized' }}
                        </span>
                        @if($item->description)
                            <p class="text-[#1a2e2a]/70 text-sm font-light italic leading-relaxed">
                                {{ $item->description }}
                            </p>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-20 text-gray-500">
                    <p class="text-xl font-serif text-[#1a2e2a] mb-2">No Images Yet</p>
                    <p class="text-sm font-light">Images added from the admin panel will appear here.</p>
                </div>
            @endforelse
        </div>
    </div>

    <div x-show="selectedImg" 
         x-transition.opacity
         class="fixed inset-0 z-[100] bg-black/95 flex items-center justify-center p-4 backdrop-blur-sm"
         @click="selectedImg = null"
         style="display: none;">
        <button class="absolute top-8 right-8 text-white/70 hover:text-white transition-colors">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
        <img :src="selectedImg" class="max-w-full max-h-[90vh] object-contain shadow-2xl rounded-sm" @click.stop>
    </div>
</div>