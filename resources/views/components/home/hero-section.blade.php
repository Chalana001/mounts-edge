<section class="relative h-screen w-full overflow-hidden bg-black font-sans" 
    x-data="heroComponent()" 
    x-init="initComponent()"
    @resize.window="windowWidth = window.innerWidth">

    <div class="absolute inset-0 z-0">
        {{-- The div for every slide still exists so the cross-fade has something
             to fade between, but background-image is only bound once a slide is
             in `loaded`. An unset url() is never fetched, so instead of pulling
             all six full-size backgrounds on first paint we pull the current one
             plus the next, then fetch the rest on demand as the user advances. --}}
        <template x-for="slide in slides" :key="'bg-'+slide.id">
            <div class="absolute inset-0 bg-cover bg-center transition-all ease-in-out"
                 :class="activeBg.id === slide.id ? 'opacity-100 scale-105 duration-1000' : 'opacity-0 scale-100 duration-1000'"
                 :style="isLoaded(slide.id) ? backgroundFor(slide) : ''">
            </div>
        </template>
        
        <div class="absolute inset-0 bg-gradient-to-r from-black/90 via-black/60 to-transparent"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
        
        <div class="absolute right-0 top-1/2 -translate-y-1/2 overflow-hidden pointer-events-none z-0">
            <div aria-hidden="true" class="text-[15vw] font-black uppercase whitespace-nowrap text-brand-green opacity-[0.2] translate-x-10 transition-all duration-500 ease-in-out"
                x-text="activeBg.bgWord">
            </div>
        </div>
    </div>

    <div class="relative z-10 w-full h-full flex flex-col md:flex-row px-6 md:px-16 pt-24 pb-6 md:pb-16 md:items-center">

        <div class="flex-1 flex flex-col justify-center items-start text-left w-full max-w-2xl min-w-0 md:h-full transition-all duration-500">
            
            <div x-show="textShown"
                 x-transition:enter="transition ease-out duration-500 delay-50"
                 x-transition:enter-start="opacity-0 translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-4"
                 class="mb-6">
                <span class="text-brand-cream/70 font-sans text-[clamp(11px,1.5vw,12px)] tracking-[0.3em] uppercase font-semibold drop-shadow-md"
                      x-text="activeText.subtitle">
                </span>
            </div>

            <h1 x-show="textShown"
                x-transition:enter="transition ease-out duration-500 delay-[0ms]"
                x-transition:enter-start="opacity-0 translate-y-8"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 -translate-y-8"
                class="text-[clamp(2.25rem,7.5vw,6rem)] font-serif font-normal text-brand-cream leading-[1.05] tracking-tight drop-shadow-2xl mb-6"
                x-html="activeText.titleHtml ?? activeText.title">
            </h1>

            <div x-show="textShown"
                 x-transition:enter="transition ease-out duration-500 delay-100"
                 x-transition:enter-start="opacity-0 scale-x-0"
                 x-transition:enter-end="opacity-100 scale-x-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-x-100"
                 x-transition:leave-end="opacity-0 scale-x-0"
                 class="w-16 h-[2px] bg-brand-orange mb-8 origin-left"> 
            </div>

            <p x-show="textShown"
               x-transition:enter="transition ease-out duration-500 delay-100"
               x-transition:enter-start="opacity-0 translate-y-4"
               x-transition:enter-end="opacity-100 translate-y-0"
               x-transition:leave="transition ease-in duration-200"
               x-transition:leave-start="opacity-100 translate-y-0"
               x-transition:leave-end="opacity-0 -translate-y-4"
               class="max-w-md text-brand-cream/80 text-[clamp(0.8rem,1.8vw,1rem)] font-light leading-relaxed mb-[clamp(1.25rem,3vw,2.5rem)]"
               x-text="activeText.description">
            </p>

            <div x-show="textShown"
                 x-transition:enter="transition ease-out duration-500 delay-150"
                 x-transition:enter-start="opacity-0 translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 translate-y-4"
                 class="flex flex-row gap-4 mb-0 md:mb-16">

                <a href="/luxury-stay" class="px-[clamp(1.25rem,3.5vw,2rem)] py-[clamp(0.65rem,1.8vw,0.875rem)] text-[clamp(11px,1.4vw,12px)] font-semibold tracking-[0.15em] uppercase border border-brand-cream/40 text-brand-cream hover:bg-brand-cream hover:text-black transition-all duration-300 rounded-sm">
                    Stay
                </a>

                <a href="/weddings" class="px-[clamp(1.25rem,3.5vw,2rem)] py-[clamp(0.65rem,1.8vw,0.875rem)] text-[clamp(11px,1.4vw,12px)] font-semibold tracking-[0.15em] uppercase bg-brand-cream text-black hover:bg-brand-green hover:text-white transition-all duration-300 rounded-sm shadow-lg">
                    Celebrate
                </a>
            </div>
        </div>

        {{-- Mobile: sits in normal flow under the text so it can never overlap it,
             but stretched past the container's right padding (w-full + 1.5rem) and
             right-aligned, so the partial card is clipped by the screen edge exactly
             like it is on desktop instead of stopping short with dead space beside it.
             Desktop: floats at the bottom-right edge of the hero, as designed. --}}
        <div class="w-[calc(100%+1.5rem)] mt-8 md:mt-0 md:absolute md:right-0 md:bottom-16 md:w-auto overflow-hidden z-20"
             x-show="shown"
             x-transition:enter="transition ease-out duration-1000 delay-100"
             x-transition:enter-start="opacity-0 translate-y-12"
             x-transition:enter-end="opacity-100 translate-y-0">

            <div class="overflow-hidden max-w-full ml-auto md:ml-0 transition-all duration-300 ease-in-out" :style="`width: ${containerWidth};`">
                
                <div x-ref="thumbTrack" class="flex w-max">
                    <template x-for="(slide, index) in thumbnailList" :key="slide.id">
                        <div class="transition-all duration-500 ease-in-out flex-none"
                             :style="(animatingType === 'next' && index === 0) || (animatingType === 'prev_start' && index === 0) ? 'width: 0px; margin-right: 0px; opacity: 0;' : `margin-right: ${cardGap}px; width: ${cardWidth}px;`">
                            
                            <div class="transition-transform duration-500 ease-in-out origin-center w-full h-full"
                                 :style="`transform: ${(animatingType === 'next' && index === 0) || (animatingType === 'prev_start' && index === 0) ? 'scale(0.5)' : 'scale(1)'};`">

                                <div class="relative rounded-2xl border border-white/20 overflow-hidden shadow-2xl transition-all duration-500"
                                     :style="`width: ${cardWidth}px; height: ${cardHeight}px;`">
                                    
                                    {{-- slide.thumb, not slide.image: these cards cap at
                                         180px wide, so pointing them at the full-size
                                         background was pulling every hero master on load
                                         even when only one was on screen.

                                         template x-if, not x-show, so a slide without a
                                         WebP thumbnail emits no <source> at all -- an empty
                                         srcset would match nothing and blank the card. --}}
                                    <picture class="contents">
                                        <template x-if="slide.thumbWebp">
                                            <source type="image/webp" :srcset="slide.thumbWebp">
                                        </template>
                                        <img :src="slide.thumb"
                                             :alt="slide.title"
                                             width="400" height="620"
                                             decoding="async"
                                             class="absolute inset-0 w-full h-full object-cover" />
                                    </picture>
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent"></div>
                                    
                                    <div class="absolute bottom-3 md:bottom-4 left-3 md:left-4 right-3 md:right-4 text-left">
                                        <span class="text-white/70 text-[11px] uppercase tracking-[0.15em] md:tracking-[0.2em] block mb-1 font-semibold" x-text="slide.subtitle.split('·')[0]"></span>
                                        <h3 class="text-white text-xs md:text-sm lg:text-base font-serif tracking-wide leading-tight drop-shadow-lg" x-text="slide.title"></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <div x-show="shown" 
         x-transition:enter="transition ease-out duration-1000 delay-100"
         x-transition:enter-start="opacity-0 translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         {{-- Mobile: centred, sitting just above the card strip.
              Desktop: pinned immediately left of the strip, so the arrows can
              never collide with the cards at any viewport width. --}}
         class="absolute z-30 flex items-center gap-4 left-1/2 -translate-x-1/2 md:left-auto md:translate-x-0 md:bottom-8"
         :style="windowWidth < 768
            ? `bottom: ${cardHeight + 56}px`
            : `right: calc(${containerWidth} + 2rem)`">
         
        <button @click="prevSlide()" class="w-10 h-10 md:w-12 md:h-12 rounded-full border border-brand-cream/30 flex items-center justify-center text-brand-cream hover:bg-brand-cream hover:text-black transition-colors cursor-pointer group">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 md:w-5 md:h-5 transition-transform group-hover:-translate-x-1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
            </svg>
        </button>

        <button @click="nextSlide()" class="w-10 h-10 md:w-12 md:h-12 rounded-full border border-brand-cream/30 flex items-center justify-center text-brand-cream hover:bg-brand-cream hover:text-black transition-colors cursor-pointer group">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 md:w-5 md:h-5 transition-transform group-hover:translate-x-1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
            </svg>
        </button>
    </div>

</section>

@php
    // Built here rather than inline in JS so the WebP siblings can be probed on
    // disk. Not every image gets one -- a conversion that saves too little is
    // discarded by ImageOptimizer -- so `webp` is null for those and the slide
    // simply falls back to the JPEG.
    $heroSlides = [
        ['id' => 1, 'title' => 'Mounts Edge Regency', 'titleHtml' => 'Mounts <span class="text-brand-orange">Edge</span> Regency', 'subtitle' => 'Gurulupotha · Mahiyangana', 'bgWord' => 'MOUNTS', 'description' => 'A mountain retreat where stillness meets celebration', 'file' => 'mounts-edge-regency'],
        // 'base' overrides the default folder. This slide shares the /luxury-stay
        // page-hero photo, which used to be a second byte-identical copy at
        // home/hero/luxury-suites.jpg.
        ['id' => 2, 'title' => 'Luxury Suites', 'subtitle' => 'Elegant Stays · Comfort', 'bgWord' => 'LUXURY', 'description' => 'Wake up to the panoramic views of the misty mountains', 'file' => 'stay', 'base' => '/storage/hero-images/'],
        ['id' => 3, 'title' => 'Grand Weddings', 'subtitle' => 'Celebrate Love · Nature', 'bgWord' => 'WEDDING', 'description' => 'Celebrate your wedding day surrounded by mountains and forest', 'file' => 'wedding'],
        ['id' => 4, 'title' => 'Fine Dining', 'subtitle' => 'Culinary Journey · Taste', 'bgWord' => 'DINING', 'description' => 'Experience authentic local and international cuisine', 'file' => 'dining'],
        ['id' => 5, 'title' => 'Infinity Edge', 'subtitle' => 'Refresh · Unwind', 'bgWord' => 'INFINITY', 'description' => 'Swim in our infinity pool, with the misty mountains right at the edge.', 'file' => 'pool4'],
        ['id' => 6, 'title' => 'Nature Trails', 'subtitle' => 'Explore · Outdoors', 'bgWord' => 'NATURE', 'description' => 'Explore nature trails through the surrounding hills', 'file' => 'nature-trails'],
    ];

    $heroSlides = collect($heroSlides)->map(function (array $slide) {
        $base = ($slide['base'] ?? '/storage/home/hero/').$slide['file'];

        $withWebp = function (string $path) {
            $webp = preg_replace('/\.[^.]+$/', '.webp', $path);

            return is_file(public_path($webp)) ? $webp : null;
        };

        return array_merge($slide, [
            'image'     => "{$base}.jpg",
            'webp'      => $withWebp("{$base}.jpg"),
            'thumb'     => "{$base}-400w.jpg",
            'thumbWebp' => $withWebp("{$base}-400w.jpg"),
        ]);
    })->values()->all();
@endphp

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('heroComponent', () => {
            const slidesData = @json($heroSlides);

            return {
                shown: false,
                textShown: false,
                slides: slidesData,
                
                bgIndex: 0,
                textIndex: 0,
                trackIndex: 0,
                
                isAnimating: false,
                animatingType: null,
                windowWidth: window.innerWidth,

                // Ids whose background-image has been bound. Only these are
                // ever fetched; the rest stay unbound until navigated to.
                loaded: [],

                initComponent() {
                    this.markLoaded(this.bgIndex);
                    setTimeout(() => {
                        this.shown = true;
                        this.textShown = true;
                    }, 100);
                },

                isLoaded(id) { return this.loaded.includes(id); },

                /**
                 * These are CSS backgrounds, so <picture> is not available and
                 * WebP has to be negotiated in CSS instead.
                 *
                 * Two background-image declarations are emitted deliberately:
                 * a browser that understands image-set() takes the second and
                 * picks WebP, while one that does not discards it as invalid and
                 * keeps the plain url() above. No feature detection needed.
                 */
                backgroundFor(slide) {
                    const jpeg = `background-image: url('${slide.image}');`;

                    if (!slide.webp) return jpeg;

                    return jpeg + ` background-image: image-set(url('${slide.webp}') type('image/webp'), url('${slide.image}') type('image/jpeg'));`;
                },

                /**
                 * Binds the given slide and the one after it. Fetching the next
                 * background up front means the cross-fade has it decoded by the
                 * time the user clicks, so deferring costs no visible latency.
                 */
                markLoaded(index) {
                    for (const i of [index, (index + 1) % this.slides.length]) {
                        const id = this.slides[i].id;
                        if (!this.loaded.includes(id)) this.loaded.push(id);
                    }
                },

                get activeBg() { return this.slides[this.bgIndex]; },
                get activeText() { return this.slides[this.textIndex]; },
                
                get thumbnailList() {
                    let list = [];
                    for (let i = 1; i <= this.slides.length; i++) {
                        list.push(this.slides[(this.trackIndex + i) % this.slides.length]);
                    }
                    return list;
                },

                get cardWidth() {
                    // Continuous scaling with the viewport so the strip never
                    // jumps between fixed sizes or collides with the hero text.
                    const vw = this.windowWidth;
                    if (vw >= 768) return Math.round(Math.min(180, Math.max(96, vw * 0.13)));
                    return Math.round(Math.min(120, Math.max(80, vw * 0.24)));
                },

                get cardHeight() {
                    return Math.round(this.cardWidth * 1.55);
                },

                get cardGap() {
                    return this.windowWidth >= 640 ? 16 : 10;
                },

                get visibleCards() {
                    // Fewer cards on narrow tablets so the strip leaves room
                    // for the hero text column beside it.
                    if (this.windowWidth >= 1024) return 3.5;
                    if (this.windowWidth >= 768) return 2.5;
                    return 3.5;
                },

                get containerWidth() {
                    const n = this.visibleCards;
                    return `calc((${this.cardWidth}px * ${n}) + (${this.cardGap}px * ${Math.ceil(n) - 1}))`;
                },

                nextSlide() {
                    if (this.isAnimating) return;
                    this.isAnimating = true;
                    
                    this.textShown = false;
                    this.animatingType = 'next';
                    this.bgIndex = (this.bgIndex + 1) % this.slides.length;
                    this.markLoaded(this.bgIndex);

                    setTimeout(() => {
                        this.textIndex = this.bgIndex;
                        this.textShown = true;
                    }, 200);

                    setTimeout(() => {
                        this.trackIndex = this.bgIndex;
                        this.animatingType = null;
                        this.isAnimating = false;
                    }, 500); 
                },

                prevSlide() {
                    if (this.isAnimating) return;
                    this.isAnimating = true;
                    
                    this.textShown = false;
                    this.bgIndex = (this.bgIndex - 1 + this.slides.length) % this.slides.length;
                    // Seed from the slide before this one, so markLoaded's
                    // look-ahead covers the direction the user is actually
                    // travelling as well as the slide now on screen.
                    this.markLoaded((this.bgIndex - 1 + this.slides.length) % this.slides.length);

                    this.trackIndex = this.bgIndex;
                    this.animatingType = 'prev_start';

                    this.$nextTick(() => {
                        void document.body.offsetHeight;
                        this.animatingType = null; 
                    });

                    setTimeout(() => {
                        this.textIndex = this.bgIndex;
                        this.textShown = true;
                    }, 200);

                    setTimeout(() => {
                        this.isAnimating = false;
                    }, 500);
                }
            }
        });
    });
</script>