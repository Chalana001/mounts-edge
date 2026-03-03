<section class="relative h-screen w-full overflow-hidden bg-black font-sans" 
    x-data="heroComponent()" 
    x-init="initComponent()"
    @resize.window="windowWidth = window.innerWidth">

    <div class="absolute inset-0 z-0">
        <template x-for="slide in slides" :key="'bg-'+slide.id">
            <div class="absolute inset-0 bg-cover bg-center transition-all ease-in-out"
                 :class="activeBg.id === slide.id ? 'opacity-100 scale-105 duration-1000' : 'opacity-0 scale-100 duration-1000'"
                 :style="`background-image: url('${slide.image}');`">
            </div>
        </template>
        
        <div class="absolute inset-0 bg-gradient-to-r from-black/90 via-black/60 to-transparent"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
        
        <div class="absolute right-0 top-1/2 -translate-y-1/2 overflow-hidden pointer-events-none z-0">
            <h2 class="text-[15vw] font-black uppercase whitespace-nowrap text-brand-green opacity-[0.2] translate-x-10 transition-all duration-500 ease-in-out"
                x-text="activeBg.bgWord">
            </h2>
        </div>
    </div>

    <div class="relative z-10 w-full h-full flex flex-col md:flex-row px-6 md:px-16 pt-24 pb-12 md:pb-16 items-end md:items-center">
        
        <div class="flex-1 flex flex-col justify-center items-start text-left w-full max-w-2xl h-full pb-32 md:pb-0 transition-all duration-500">
            
            <div x-show="textShown"
                 x-transition:enter="transition ease-out duration-500 delay-50"
                 x-transition:enter-start="opacity-0 translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-4"
                 class="mb-6">
                <span class="text-[#F5F5DC]/70 font-sans text-[10px] md:text-xs tracking-[0.3em] uppercase font-semibold drop-shadow-md" 
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
                class="text-6xl md:text-7xl lg:text-[6rem] font-serif font-normal text-[#F5F5DC] leading-[1.05] tracking-tight drop-shadow-2xl mb-6"
                x-text="activeText.title">
            </h1>

            <div x-show="textShown"
                 x-transition:enter="transition ease-out duration-500 delay-100"
                 x-transition:enter-start="opacity-0 scale-x-0"
                 x-transition:enter-end="opacity-100 scale-x-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-x-100"
                 x-transition:leave-end="opacity-0 scale-x-0"
                 class="w-16 h-[2px] bg-[#d37841] mb-8 origin-left"> 
            </div>

            <p x-show="textShown"
               x-transition:enter="transition ease-out duration-500 delay-100"
               x-transition:enter-start="opacity-0 translate-y-4"
               x-transition:enter-end="opacity-100 translate-y-0"
               x-transition:leave="transition ease-in duration-200"
               x-transition:leave-start="opacity-100 translate-y-0"
               x-transition:leave-end="opacity-0 -translate-y-4"
               class="max-w-md text-[#F5F5DC]/80 text-sm md:text-base font-light leading-relaxed mb-10"
               x-text="activeText.description">
            </p>

            <div x-show="textShown"
                 x-transition:enter="transition ease-out duration-500 delay-150"
                 x-transition:enter-start="opacity-0 translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 translate-y-4"
                 class="flex flex-row gap-4 mb-12 md:mb-16">
                
                <a href="/stay" class="px-8 py-3.5 text-xs font-semibold tracking-[0.15em] uppercase border border-[#F5F5DC]/40 text-[#F5F5DC] hover:bg-[#F5F5DC] hover:text-black transition-all duration-300 rounded-sm">
                    Stay
                </a>

                <a href="/celebrate" class="px-8 py-3.5 text-xs font-semibold tracking-[0.15em] uppercase bg-[#F5F5DC] text-black hover:bg-[#d37841] hover:text-white transition-all duration-300 rounded-sm shadow-lg">
                    Celebrate
                </a>
            </div>
        </div>

        <div class="absolute bottom-6 left-0 w-full pl-6 md:pl-0 md:w-auto md:left-auto md:right-0 md:bottom-16 z-20"
             x-show="shown"
             x-transition:enter="transition ease-out duration-1000 delay-100"
             x-transition:enter-start="opacity-0 translate-y-12"
             x-transition:enter-end="opacity-100 translate-y-0">
            
            <div class="overflow-hidden transition-all duration-300 ease-in-out" :style="`width: ${containerWidth};`">
                
                <div x-ref="thumbTrack" class="flex w-max">
                    <template x-for="(slide, index) in thumbnailList" :key="slide.id">
                        <div class="transition-all duration-500 ease-in-out flex-none"
                             :style="(animatingType === 'next' && index === 0) || (animatingType === 'prev_start' && index === 0) ? 'width: 0px; margin-right: 0px; opacity: 0;' : `margin-right: ${cardGap}px; width: ${cardWidth}px;`">
                            
                            <div class="transition-transform duration-500 ease-in-out origin-center w-full h-full"
                                 :style="`transform: ${(animatingType === 'next' && index === 0) || (animatingType === 'prev_start' && index === 0) ? 'scale(0.5)' : 'scale(1)'};`">

                                <div class="relative rounded-2xl border border-white/20 overflow-hidden shadow-2xl transition-all duration-500"
                                     :style="`width: ${cardWidth}px; height: ${cardHeight}px;`">
                                    
                                    <img :src="slide.image" class="absolute inset-0 w-full h-full object-cover" alt="thumbnail" />
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent"></div>
                                    
                                    <div class="absolute bottom-3 md:bottom-4 left-3 md:left-4 right-3 md:right-4 text-left">
                                        <span class="text-white/70 text-[7px] md:text-[9px] uppercase tracking-[0.2em] block mb-1 font-semibold" x-text="slide.subtitle.split('·')[0]"></span>
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
         class="absolute bottom-8 left-1/2 -translate-x-1/2 z-30 flex items-center gap-4">
         
        <button @click="prevSlide()" class="w-10 h-10 md:w-12 md:h-12 rounded-full border border-[#F5F5DC]/30 flex items-center justify-center text-[#F5F5DC] hover:bg-[#F5F5DC] hover:text-black transition-colors cursor-pointer group">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 md:w-5 md:h-5 transition-transform group-hover:-translate-x-1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
            </svg>
        </button>

        <button @click="nextSlide()" class="w-10 h-10 md:w-12 md:h-12 rounded-full border border-[#F5F5DC]/30 flex items-center justify-center text-[#F5F5DC] hover:bg-[#F5F5DC] hover:text-black transition-colors cursor-pointer group">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 md:w-5 md:h-5 transition-transform group-hover:translate-x-1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
            </svg>
        </button>
    </div>

</section>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('heroComponent', () => {
            const slidesData = [
                { id: 1, title: 'Mounts Edge Regency', subtitle: 'Gurulupotha · Mahiyangana', bgWord: 'MOUNTS', description: 'A mountain retreat where stillness meets celebration', image: '/storage/home/hero/mounts-edge-regency.jpg' },
                { id: 2, title: 'Luxury Suites', subtitle: 'Elegant Stays · Comfort', bgWord: 'LUXURY', description: 'Wake up to the panoramic views of the misty mountains', image: '/storage/home/hero/luxury-suites.jpg' },
                { id: 3, title: 'Grand Weddings', subtitle: 'Celebrate Love · Nature', bgWord: 'WEDDING', description: 'Make your special day unforgettable amidst nature', image: '/storage/home/hero/wedding.jpg' },
                { id: 4, title: 'Fine Dining', subtitle: 'Culinary Journey · Taste', bgWord: 'DINING', description: 'Experience authentic local and international cuisine', image: '/storage/home/hero/dining.jpg' },
                { id: 5, title: 'Infinity Edge', subtitle: 'Refresh · Unwind', bgWord: 'INFINITY', description: 'Immerse yourself in crystal clear waters that seamlessly blend with the misty mountains.', image: '/storage/home/hero/pool4.jpg' },
                { id: 6, title: 'Nature Trails', subtitle: 'Explore · Outdoors', bgWord: 'NATURE', description: 'Discover hidden paths and breathtaking landscapes', image: '/storage/home/hero/nature-trails.jpg' }
            ];

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
                
                initComponent() {
                    setTimeout(() => {
                        this.shown = true;
                        this.textShown = true;
                    }, 100);
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
                    if (this.windowWidth >= 1024) return 180;
                    if (this.windowWidth >= 768) return 150;
                    if (this.windowWidth >= 640) return 120;
                    return 100;
                },

                get cardHeight() {
                    if (this.windowWidth >= 1024) return 280;
                    if (this.windowWidth >= 768) return 230;
                    if (this.windowWidth >= 640) return 180;
                    return 140;
                },

                get cardGap() {
                    return this.windowWidth >= 640 ? 16 : 10;
                },

                get containerWidth() {
                    return `calc((${this.cardWidth}px * 3.5) + (${this.cardGap}px * 3))`; 
                },

                nextSlide() {
                    if (this.isAnimating) return;
                    this.isAnimating = true;
                    
                    this.textShown = false;
                    this.animatingType = 'next';
                    this.bgIndex = (this.bgIndex + 1) % this.slides.length;

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