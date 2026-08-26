<section class="py-12 bg-[#f9f9f7]"
         x-data="{ isVisible: false }"
         x-intersect.once.margin.-25%.0px.-25%.0px="isVisible = true">
    <div class="container mx-auto px-6">
        
        <div class="text-center mb-16 reveal-fade"
             :class="isVisible ? 'reveal-visible' : ''"
             style="transition-duration: 1.2s;">
            <span class="text-brand-green/70 text-xs tracking-[0.2em] uppercase mb-4 block">Picture Perfect</span>
            <h2 class="text-4xl md:text-5xl font-serif text-brand-green mb-6">Outdoor Photo Spots</h2>
            <p class="text-brand-green/70 max-w-xl mx-auto font-light">
                Capture your wedding photos against our mountain backdrop
            </p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 max-w-5xl mx-auto">
            @foreach([
                ['stem' => '1', 'w' => 1200, 'h' => 1200],
                ['stem' => '2', 'w' => 842,  'h' => 960],
                ['stem' => '3', 'w' => 1200, 'h' => 900],
                ['stem' => '4', 'w' => 1200, 'h' => 979],
            ] as $index => $spot)
                @php $base = "/storage/weddings/highlights/{$spot['stem']}"; @endphp

                <div class="aspect-square overflow-hidden group reveal-scale"
                     :class="isVisible ? 'reveal-visible' : ''"
                     style="transition-duration: 1s; transition-delay: {{ $index * 150 }}ms;">

                    {{-- Four tiles ~240px wide in a max-w-5xl grid; as CSS
                         backgrounds they all loaded up front. --}}
                    <x-responsive-image :src="$base.'.jpg'"
                                        :widths="[400, 800]"
                                        sizes="(min-width: 768px) 240px, 45vw"
                                        alt="Wedding photo spot at Mounts Edge Regency"
                                        loading="lazy" decoding="async"
                                        class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" />
                </div>
            @endforeach
        </div>
    </div>
</section>