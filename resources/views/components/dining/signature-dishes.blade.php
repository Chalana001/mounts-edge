<section class="py-24 md:py-32 bg-[#f9f9f7]" 
         x-data="{ isVisible: false }" 
         x-intersect.once.margin.-10%.0.-10%.0="isVisible = true">
    
    <div class="container mx-auto px-6">
        <div class="text-center mb-16 reveal-hidden" :class="isVisible ? 'reveal-visible' : ''">
            <span class="text-brand-green/70 text-xs tracking-[0.2em] uppercase mb-4 block">Our Menu</span>
            <h2 class="text-4xl md:text-5xl font-serif text-brand-green mb-6">Global & Local Flavors</h2>
            <p class="text-brand-green/70 max-w-xl mx-auto font-light">Experience a diverse culinary journey ranging from authentic village recipes to beloved international classics.</p>
        </div>

        @php
            // New Menu Types added with matching descriptions and images
            $dishes = [
                [
                    'name' => 'Authentic Sri Lankan', 
                    'desc' => 'A fiery selection of traditional village recipes, curries, and local delicacies.', 
                    'img' => 'https://images.unsplash.com/photo-1567620905732-2d1ec7ab7445?w=600&q=80'
                ],
                [
                    'name' => 'Western', 
                    'desc' => 'Premium continental dishes, grilled steaks, and comforting pastas.', 
                    'img' => 'https://images.unsplash.com/photo-1544025162-d76694265947?w=600&q=80'
                ],
                [
                    'name' => 'Indian', 
                    'desc' => 'Rich gravies, aromatic biryanis, and traditional tandoori specialties.', 
                    'img' => 'https://images.unsplash.com/photo-1585937421612-70a008356fbe?w=600&q=80'
                ],
                [
                    'name' => 'Chinese', 
                    'desc' => 'Classic wok-tossed dishes, savory dumplings, and oriental stir-fries.', 
                    'img' => 'https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?w=600&q=80'
                ],
            ];
        @endphp

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8 max-w-6xl mx-auto">
            @foreach($dishes as $index => $dish)
                <div class="group reveal-hidden" 
                     style="transition-delay: {{ $index * 150 }}ms"
                     :class="isVisible ? 'reveal-visible' : ''">
                    <div class="overflow-hidden mb-6 aspect-square shadow-sm">
                        <img src="{{ $dish['img'] }}" alt="{{ $dish['name'] }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110">
                    </div>
                    <h3 class="font-serif text-brand-green text-lg mb-2">{{ $dish['name'] }}</h3>
                    <p class="text-brand-green/70 text-sm font-light leading-relaxed">{{ $dish['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>