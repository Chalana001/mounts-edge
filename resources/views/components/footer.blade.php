<footer class="bg-brand-green text-[#F5F5DC]">
    <div class="container mx-auto px-6 py-20">
        <div class="max-w-4xl mx-auto text-center">
            <h3 class="text-3xl font-serif font-normal mb-8 tracking-wide">Mounts Edge</h3>
            
            <p class="text-[#F5F5DC]/60 text-sm font-light leading-relaxed mb-10 max-w-md mx-auto">
                A semi-luxury retreat nestled in Gurulupotha, Mahiyangana – where tranquility meets celebration.
            </p>

            <nav class="flex flex-wrap justify-center gap-8 mb-12">
                @php
                    $footerLinks = [
                        ['name' => 'Stay', 'path' => '/luxury-stay'],
                        ['name' => 'Weddings', 'path' => '/weddings'],
                        ['name' => 'Dining', 'path' => '/dining'],
                        ['name' => 'Gallery', 'path' => '/gallery'],
                        ['name' => 'Contact', 'path' => '/contact'],
                    ];
                @endphp

                @foreach($footerLinks as $link)
                    <a href="{{ $link['path'] }}" 
                       class="text-[#F5F5DC]/60 hover:text-brand-orange text-[10px] tracking-[0.2em] uppercase font-bold transition-colors duration-300">
                        {{ $link['name'] }}
                    </a>
                @endforeach
            </nav>

            <div class="w-12 h-px bg-brand-orange/30 mx-auto mb-10"></div>

            <div class="space-y-3 text-[#F5F5DC]/50 text-xs tracking-wide font-light mb-10">
                <p class="hover:text-[#F5F5DC] transition-colors cursor-default">Gurulupotha, Hasalaka, Mahiyangana, Sri Lanka</p>
                <p><a href="tel:0552256500" class="hover:text-[#F5F5DC] transition-colors">055 2 256 500</a></p>
                <p><a href="mailto:ckalhara7277@gmail.com" class="hover:text-[#F5F5DC] transition-colors">ckalhara7277@gmail.com</a></p>
            </div>
        </div>

        <div class="border-t border-[#F5F5DC]/10 pt-8 text-center">
            <p class="text-[#F5F5DC]/30 text-[10px] tracking-widest uppercase font-light">
                &copy; {{ date('Y') }} Mounts Edge Regency. All Rights Reserved.
            </p>
        </div>
    </div>
</footer>