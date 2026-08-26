<section class="py-12 md:py-20 bg-[#f9f9f7] overflow-hidden"
         x-data="{ isVisible: false }" 
         x-intersect.once.margin.-25%.0.-25%.0="isVisible = true">
    
    <div class="container mx-auto px-6">
        <div class="grid md:grid-cols-2 gap-8 lg:gap-16 items-center max-w-6xl mx-auto">
            
            <div class="order-2 md:order-1 reveal-left"
                 :class="isVisible ? 'reveal-visible' : ''"
                 style="transition-duration: 1.5s;">
                <div class="relative group">
                    <div class="aspect-square overflow-hidden shadow-2xl">
                        {{-- bg-cover/bg-center were no-ops here: those style a CSS
                             background, not an <img>. The fill only looked correct
                             because the source happens to be square; object-cover is
                             what actually holds the aspect ratio. --}}
                        <x-responsive-image src="/storage/home/pool-highlight.jpg"
                                            :widths="[600, 1200]"
                                            sizes="(min-width: 768px) 50vw, 100vw"
                                            alt="The mountain-view infinity pool at Mounts Edge Regency"
                                            loading="lazy" decoding="async"
                                            class="w-full h-full object-cover transition-transform duration-[3000ms] group-hover:scale-110" />
                    </div>
                    <div class="absolute -top-4 -left-4 w-24 h-24 border-t border-l border-brand-orange/50"></div>
                </div>
            </div>

            <div class="order-1 md:order-2">
                <div class="reveal-right"
                     :class="isVisible ? 'reveal-visible' : ''"
                     style="transition-delay: 400ms;">
                    
                    <span class="text-brand-green/70 text-[11px] tracking-[0.4em] uppercase font-bold block mb-4">
                        The Pool
                    </span>
                    
                    <h2 class="text-3xl md:text-5xl font-serif text-brand-green font-normal mb-8 leading-tight">
                        Serenity Above <br>the Clouds
                    </h2>
                    
                    <p class="text-brand-green/70 leading-relaxed mb-10 font-light text-lg">
                        Our infinity pool sits right on the edge of the range, looking out over the valley. It's set away from the road and the rest of the property, so it stays <b>private</b> even when we're full.
                    </p>

                    <div class="flex flex-wrap gap-3 mb-12">
                        @php
                            $poolFeatures = ["Infinity Edge", "Mountain View", "Absolute Privacy", "Kids Section", "Poolside Service"];
                        @endphp

                        @foreach($poolFeatures as $feature)
                            <span class="text-[11px] tracking-[0.1em] uppercase text-brand-green/70 border border-brand-green/20 px-5 py-2.5 bg-white/50 backdrop-blur-sm">
                                {{ $feature }}
                            </span>
                        @endforeach
                    </div>

                    <p class="text-brand-green/70 text-sm italic mb-10 border-l-2 border-brand-orange/30 pl-6">
                        "A dedicated safe-zone for children ensures family fun, while the clever architectural design keeps your moments private and undisturbed."
                    </p>

                    <a href="/experiences" 
                       class="inline-flex items-center gap-4 text-brand-green hover:gap-6 transition-all duration-500 group">
                        <span class="text-[11px] tracking-[0.2em] uppercase font-bold">Explore Wellness</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>