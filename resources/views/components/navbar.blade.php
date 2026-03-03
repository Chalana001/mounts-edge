<nav x-data="{ 
        isOpen: false, 
        isScrolled: false,
        currentPath: window.location.pathname,
        init() {
            // පේජ් එක ලෝඩ් වෙද්දිම scroll වෙලාද බලනවා
            this.isScrolled = window.scrollY > 50; 
            
            // Scroll කරද්දි තත්වය මාරු කරනවා
            window.addEventListener('scroll', () => {
                this.isScrolled = window.scrollY > 50;
            });

            // Mobile Menu එක ඕපන් කරාම Background Scroll වෙන එක නවත්තනවා
            this.$watch('isOpen', value => {
                if (value) {
                    document.body.style.overflow = 'hidden';
                } else {
                    document.body.style.overflow = '';
                }
            });
        }
    }" 
    class="fixed top-0 left-0 right-0 z-50 w-full">

    @php
        $navLinks = [
            ['name' => 'Stay',        'url' => '/luxury-stay'],
            ['name' => 'Weddings',    'url' => '/weddings'],
            ['name' => 'Dining',      'url' => '/dining'],
            ['name' => 'Experiences', 'url' => '/experiences'],
            ['name' => 'Gallery',     'url' => '/gallery'],
            ['name' => 'Contact',     'url' => '/contact'],
        ];
    @endphp

    <div class="absolute inset-0 transition-all duration-500 -z-10"
         :class="isScrolled ? 'bg-brand-light/95 backdrop-blur-sm border-b border-brand-green/20 shadow-sm' : 'bg-transparent'">
    </div>

    <div class="container mx-auto px-6 flex items-center justify-between transition-all duration-500 relative z-[60]"
         :class="isScrolled ? 'py-4' : 'py-6'">
        
        <a href="/" class="relative group flex items-center">
            <h1 class="text-xl md:text-2xl font-serif font-normal tracking-wide transition-colors duration-500"
                :class="isScrolled || isOpen ? 'text-brand-green' : 'text-brand-light'">
                Mounts Edge Regency
            </h1>
        </a>

        <div class="hidden lg:flex items-center gap-10">
            @foreach($navLinks as $link)
                <a href="{{ $link['url'] }}" 
                   class="text-[10px] tracking-[0.15em] uppercase font-bold transition-colors duration-300 relative group"
                   :class="isScrolled ? (currentPath === '{{ $link['url'] }}' ? 'text-brand-orange' : 'text-brand-green hover:text-brand-orange') : (currentPath === '{{ $link['url'] }}' ? 'text-brand-orange' : 'text-brand-light/80 hover:text-brand-light')">
                    {{ $link['name'] }}
                    
                    <span class="absolute -bottom-2 left-0 w-full h-[1px] transition-transform duration-300 origin-left"
                          :class="currentPath === '{{ $link['url'] }}' ? 'scale-x-100 bg-brand-orange' : 'scale-x-0 bg-current group-hover:scale-x-100'">
                    </span>
                </a>
            @endforeach

            <a href="/contact" 
               class="px-8 py-4 text-[10px] tracking-[0.15em] uppercase font-bold transition-all duration-500"
               :class="isScrolled 
                    ? 'bg-brand-green text-brand-light hover:bg-brand-orange' 
                    : 'bg-brand-light/10 border border-brand-light/30 text-brand-light hover:bg-brand-light hover:text-brand-green'">
                Book
            </a>
        </div>

        <button @click="isOpen = !isOpen" class="lg:hidden p-2 focus:outline-none" aria-label="Toggle menu">
            <svg x-show="!isOpen" class="w-6 h-6 transition-colors duration-300" :class="isScrolled ? 'text-brand-green' : 'text-brand-light'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            
            <svg x-show="isOpen" class="w-6 h-6 text-brand-green" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>

    <div x-show="isOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[55] bg-[#FAF9F6] lg:hidden flex flex-col items-center justify-center gap-8"
         style="display: none;">
        
        <a href="/" class="text-brand-green text-[10px] tracking-[0.2em] uppercase font-bold hover:text-brand-orange transition-colors mb-4">
            Home
        </a>

        @foreach($navLinks as $index => $link)
            <div x-show="isOpen"
                 x-transition:enter="transition ease-out duration-500 delay-[{{ $index * 50 }}ms]"
                 x-transition:enter-start="opacity-0 translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0">
                <a href="{{ $link['url'] }}" 
                   @click="isOpen = false"
                   class="text-3xl font-serif font-normal transition-colors duration-300"
                   :class="currentPath === '{{ $link['url'] }}' ? 'text-brand-orange' : 'text-brand-green hover:text-brand-orange'">
                    {{ $link['name'] }}
                </a>
            </div>
        @endforeach

        <a href="/contact" @click="isOpen = false" class="mt-8 px-12 py-5 bg-brand-green text-brand-light text-[10px] tracking-[0.2em] uppercase font-bold hover:bg-brand-orange transition-colors">
            Book Now
        </a>
    </div>
</nav>