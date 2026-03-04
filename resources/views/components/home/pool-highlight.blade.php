<section class="py-32 md:py-40 bg-[#f9f9f7] overflow-hidden" 
         x-data="{ isVisible: false }" 
         x-intersect.once.margin.-25%.0.-25%.0="isVisible = true">
    
    <div class="container mx-auto px-6">
        <div class="grid md:grid-cols-2 gap-16 lg:gap-24 items-center max-w-6xl mx-auto">
            
            <div class="order-2 md:order-1 reveal-hidden"
                 :class="isVisible ? 'reveal-visible' : ''"
                 style="transition-duration: 1.5s;">
                <div class="relative group">
                    <div class="aspect-[4/4] overflow-hidden shadow-2xl">
                        <img src="/storage/home/pool-highlight.jpg" 
                             alt="Mountain View Infinity Pool" 
                             class="w-full h-full bg-cover bg-center transition-transform duration-[3000ms] group-hover:scale-110">
                    </div>
                    <div class="absolute -top-4 -left-4 w-24 h-24 border-t border-l border-brand-orange/50"></div>
                </div>
            </div>

            <div class="order-1 md:order-2">
                <div class="reveal-hidden" 
                     :class="isVisible ? 'reveal-visible' : ''"
                     style="transition-delay: 400ms;">
                    
                    <span class="text-brand-green/70 text-[10px] tracking-[0.4em] uppercase font-bold block mb-4">
                        Highland Sanctuary
                    </span>
                    
                    <h2 class="text-3xl md:text-5xl font-serif text-brand-green font-normal mb-8 leading-tight">
                        Serenity Above <br>the Clouds
                    </h2>
                    
                    <p class="text-brand-green/70 leading-relaxed mb-10 font-light text-lg">
                        Experience the ultimate mountain retreat in our infinity pool. Perched on the edge of the range, it offers panoramic valley views while maintaining <b>absolute privacy</b> from the outside world.
                    </p>

                    <div class="flex flex-wrap gap-3 mb-12">
                        @php
                            $poolFeatures = ["Infinity Edge", "Mountain View", "Absolute Privacy", "Kids Section", "Poolside Service"];
                        @endphp

                        @foreach($poolFeatures as $feature)
                            <span class="text-[10px] tracking-[0.1em] uppercase text-brand-green/70 border border-brand-green/20 px-5 py-2.5 bg-white/50 backdrop-blur-sm">
                                {{ $feature }}
                            </span>
                        @endforeach
                    </div>

                    <p class="text-brand-green/70 text-sm italic mb-10 border-l-2 border-brand-orange/30 pl-6">
                        "A dedicated safe-zone for children ensures family fun, while the clever architectural design keeps your moments private and undisturbed."
                    </p>

                    <a href="/experiences" 
                       class="inline-flex items-center gap-4 text-brand-green hover:gap-6 transition-all duration-500 group">
                        <span class="text-[10px] tracking-[0.2em] uppercase font-bold">Explore Wellness</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>