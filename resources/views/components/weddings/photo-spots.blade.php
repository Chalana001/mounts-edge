<section class="py-24 bg-[#f9f9f7]"
         x-data="{ isVisible: false }"
         x-intersect.once.margin.-25%.0px.-25%.0px="isVisible = true">
    <div class="container mx-auto px-6">
        
        <div class="text-center mb-16 reveal-hidden"
             :class="isVisible ? 'reveal-visible' : ''"
             style="transition-duration: 1.2s;">
            <span class="text-brand-green/70 text-xs tracking-[0.2em] uppercase mb-4 block">Picture Perfect</span>
            <h2 class="text-4xl md:text-5xl font-serif text-brand-green mb-6">Outdoor Photo Spots</h2>
            <p class="text-brand-green/70 max-w-xl mx-auto font-light">
                Capture stunning moments against our breathtaking mountain backdrop
            </p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 max-w-5xl mx-auto">
            @foreach([
                "/storage/weddings/highlights/1.jpg",
                "/storage/weddings/highlights/2.jpg",
                "/storage/weddings/highlights/3.jpg",
                "/storage/weddings/highlights/4.jpg",
            ] as $index => $img)
                
                <div class="aspect-square overflow-hidden group reveal-hidden"
                     :class="isVisible ? 'reveal-visible' : ''"
                     style="transition-duration: 1s; transition-delay: {{ $index * 150 }}ms;">
                     
                    <div class="w-full h-full bg-cover bg-center transition-transform duration-1000 group-hover:scale-110"
                         style="background-image: url('{{ $img }}')"></div>
                </div>
            @endforeach
        </div>
    </div>
</section>