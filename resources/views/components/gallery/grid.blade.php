@php
    // Shared with Alpine so the lightbox can walk the filtered set instead of
    // forcing a close-and-reopen for every photo.
    $lightboxItems = $galleryItems->map(fn ($item) => [
        'src' => asset($item->image),
        'alt' => $item->description ?: (($item->category->name ?? 'Gallery') . ' at Mounts Edge Regency'),
        'category' => $item->category->name ?? 'Uncategorized',
    ])->values();

    $filters = collect(['All'])->merge($categories->pluck('name'))->values();
@endphp

<div x-data="galleryBoard(@js($lightboxItems), @js($filters))" class="py-12 md:py-20 bg-brand-light">

    <div class="text-center mb-12 px-6 reveal-fade"
         x-data="{ isHeaderVisible: false }"
         x-intersect.once.margin.-10%.0.-10%.0="isHeaderVisible = true"
         :class="isHeaderVisible ? 'reveal-visible' : ''"
         style="transition-duration: 1.2s;">
        <h2 class="text-4xl md:text-5xl font-serif text-brand-green mb-4">Our Gallery</h2>
        <p class="text-brand-green/70 font-light max-w-2xl mx-auto">A look around Mounts Edge Regency: rooms, weddings, dining, and the grounds.</p>
    </div>

    {{-- Filter chips, not tabs: they narrow one grid rather than swapping panels,
         so aria-pressed is the honest role here. --}}
    <div role="group" aria-label="Filter gallery by category"
         class="flex flex-wrap justify-center gap-2 md:gap-4 mb-10 md:mb-14 px-6 relative z-20 reveal-fade"
         x-data="{ isTabsVisible: false }"
         x-intersect.once.margin.-25%.0.-25%.0="isTabsVisible = true"
         :class="isTabsVisible ? 'reveal-visible' : ''"
         style="transition-duration: 1.2s; transition-delay: 200ms;">

        @foreach($filters as $filter)
            <button type="button"
                    @click="activeTab = @js($filter)"
                    :aria-pressed="activeTab === @js($filter) ? 'true' : 'false'"
                    class="px-6 py-3 text-[11px] tracking-widest uppercase font-bold border transition-all duration-300 shadow-sm focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-orange focus-visible:ring-offset-2"
                    :class="activeTab === @js($filter) ? 'bg-brand-green text-brand-light border-brand-green' : 'bg-white text-brand-green/70 border-brand-green/20 hover:border-brand-green hover:text-brand-green'">
                {{ $filter }}
            </button>
        @endforeach
    </div>

    <p class="sr-only" aria-live="polite" x-text="`${visibleIndices.length} photos shown${activeTab === 'All' ? '' : ` in ${activeTab}`}`"></p>

    <div class="container mx-auto px-6">
        {{-- CSS multi-column masonry: each photo keeps its own aspect ratio
             instead of being cropped to a square, so the grid reads as a
             pinboard rather than a table. break-inside-avoid stops a card
             from being split across two columns. --}}
        <div class="columns-2 lg:columns-3 xl:columns-4 gap-3 sm:gap-4 md:gap-6 reveal-scale"
             x-data="{ isGridVisible: false }"
             x-intersect.once.margin.-25%.0.-25%.0="isGridVisible = true"
             :class="isGridVisible ? 'reveal-visible' : ''"
             style="transition-duration: 1.5s; transition-delay: 400ms;">

            @forelse($galleryItems as $index => $item)
                <div x-show="activeTab === 'All' || activeTab === @js($item->category->name ?? 'Uncategorized')"
                     x-transition:enter="transition ease-out duration-500"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95 hidden"
                     style="aspect-ratio: {{ $item->aspect_ratio }};"
                     class="group relative overflow-hidden rounded-md shadow-sm bg-brand-green/10 break-inside-avoid mb-3 sm:mb-4 md:mb-6">

                    <button type="button"
                            @click="open({{ $index }})"
                            class="absolute inset-0 z-10 cursor-pointer focus:outline-none focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-brand-orange"
                            aria-label="View photo: {{ $item->description ?: ($item->category->name ?? 'Gallery') }}"></button>

                    {{-- Tiles are ~300px wide, but the lightbox reuses the full file,
                         so the original stays the largest srcset candidate. --}}
                    <x-responsive-image :src="asset($item->image)"
                                        :widths="[400, 800]"
                                        sizes="(min-width: 1280px) 25vw, (min-width: 1024px) 33vw, 50vw"
                                        :alt="$item->description"
                                        loading="lazy" decoding="async"
                                        class="absolute inset-0 w-full h-full object-cover transition-transform duration-[1500ms] group-hover:scale-110" />

                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent opacity-60 group-hover:opacity-90 transition-opacity duration-500"></div>

                    <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-center justify-center pointer-events-none">
                        <svg class="w-10 h-10 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                        </svg>
                    </div>

                    {{-- Touch devices never fire :hover, so the caption sits flush
                         on mobile and only uses the slide-up reveal from md up. --}}
                    <div class="absolute bottom-0 left-0 right-0 p-3 md:p-5 transform translate-y-0 md:translate-y-4 md:group-hover:translate-y-0 transition-transform duration-500 pointer-events-none">
                        <span class="text-[11px] tracking-[0.15em] md:tracking-[0.2em] uppercase text-brand-orange font-bold block mb-0.5 md:mb-1 drop-shadow-md">
                            {{ $item->category->name ?? 'Uncategorized' }}
                        </span>
                        @if($item->description)
                            <p class="text-white/95 text-[11px] md:text-sm font-light italic leading-snug md:leading-relaxed line-clamp-2 drop-shadow-md">
                                {{ $item->description }}
                            </p>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-20 text-brand-green/70">
                    <p class="text-xl font-serif text-brand-green mb-2">No Images Yet</p>
                    <p class="text-sm font-light">Images added from the admin panel will appear here.</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Lightbox. Escape closes, arrow keys walk the filtered set, focus moves in
         and back out, and the page behind it stops scrolling. --}}
    <div x-show="lightboxIndex !== null"
         x-transition.opacity
         role="dialog"
         aria-modal="true"
         aria-label="Photo viewer"
         @keydown.escape.window="close()"
         @keydown.arrow-right.window="next()"
         @keydown.arrow-left.window="prev()"
         @keydown.tab="trapFocus($event)"
         @click="close()"
         class="fixed inset-0 z-[100] bg-black/95 flex items-center justify-center p-4 backdrop-blur-sm"
         style="display: none;">

        <button x-ref="close" type="button" @click="close()" aria-label="Close photo viewer"
                class="absolute top-6 right-6 z-10 flex h-12 w-12 items-center justify-center rounded-full text-white/70 transition-colors hover:bg-white/10 hover:text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-orange">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>

        <button type="button" @click.stop="prev()" aria-label="Previous photo"
                x-show="visibleIndices.length > 1"
                class="absolute left-3 md:left-8 z-10 flex h-12 w-12 items-center justify-center rounded-full text-white/70 transition-colors hover:bg-white/10 hover:text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-orange">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/></svg>
        </button>

        <button type="button" @click.stop="next()" aria-label="Next photo"
                x-show="visibleIndices.length > 1"
                class="absolute right-3 md:right-8 z-10 flex h-12 w-12 items-center justify-center rounded-full text-white/70 transition-colors hover:bg-white/10 hover:text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-orange">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5 15.75 12l-7.5 7.5"/></svg>
        </button>

        <figure class="flex max-h-full flex-col items-center gap-4" @click.stop>
            <template x-if="current">
                <img :src="current.src" :alt="current.alt"
                     class="max-w-full max-h-[80vh] object-contain shadow-2xl rounded-sm">
            </template>
            <figcaption class="text-center">
                <p class="text-white/90 text-sm font-light italic" x-text="current?.alt"></p>
                <p class="mt-2 text-[11px] uppercase tracking-[0.2em] text-white/50 tabular-nums"
                   x-text="`${position + 1} / ${visibleIndices.length}`"></p>
            </figcaption>
        </figure>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('galleryBoard', (items, filters) => ({
            items,
            filters,
            activeTab: 'All',
            lightboxIndex: null,

            init() {
                // Filter state lives in the URL so a filtered view can be shared or refreshed.
                const fromUrl = new URLSearchParams(window.location.search).get('category');
                if (fromUrl && this.filters.includes(fromUrl)) this.activeTab = fromUrl;

                this.$watch('activeTab', value => {
                    const url = new URL(window.location);
                    if (value === 'All') url.searchParams.delete('category');
                    else url.searchParams.set('category', value);
                    window.history.replaceState({}, '', url);
                });

                this.$watch('lightboxIndex', value => {
                    document.body.style.overflow = value === null ? '' : 'hidden';

                    if (value !== null) {
                        this.$nextTick(() => this.$refs.close?.focus());
                    } else if (this.lastTrigger) {
                        this.lastTrigger.focus();
                        this.lastTrigger = null;
                    }
                });
            },

            lastTrigger: null,

            get visibleIndices() {
                return this.items
                    .map((item, index) => index)
                    .filter(index => this.activeTab === 'All' || this.items[index].category === this.activeTab);
            },

            get current() {
                return this.lightboxIndex === null ? null : this.items[this.lightboxIndex];
            },

            get position() {
                return this.visibleIndices.indexOf(this.lightboxIndex);
            },

            open(index) {
                this.lastTrigger = document.activeElement;
                this.lightboxIndex = index;
            },

            close() {
                this.lightboxIndex = null;
            },

            step(delta) {
                const list = this.visibleIndices;
                if (list.length < 2) return;
                const at = this.position;
                this.lightboxIndex = list[(at + delta + list.length) % list.length];
            },

            next() { this.step(1); },
            prev() { this.step(-1); },

            trapFocus(event) {
                const nodes = event.currentTarget.querySelectorAll('button');
                if (!nodes.length) return;

                const first = nodes[0];
                const last = nodes[nodes.length - 1];

                if (event.shiftKey && document.activeElement === first) {
                    event.preventDefault();
                    last.focus();
                } else if (!event.shiftKey && document.activeElement === last) {
                    event.preventDefault();
                    first.focus();
                }
            },
        }));
    });
</script>
