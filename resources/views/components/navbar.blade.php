<nav x-data="{
        isOpen: false,
        isScrolled: false,
        currentPath: window.location.pathname,
        init() {
            this.isScrolled = window.scrollY > 50;

            window.addEventListener('scroll', () => {
                this.isScrolled = window.scrollY > 50;
            });

            // Prevent the page behind the mobile menu from scrolling, and hand focus
            // to the panel so keyboard users are not left behind it.
            this.$watch('isOpen', value => {
                document.body.style.overflow = value ? 'hidden' : '';

                if (value) {
                    this.$nextTick(() => this.$refs.menu?.querySelector('a')?.focus());
                } else {
                    this.$refs.toggle?.focus();
                }
            });

            window.addEventListener('resize', () => {
                if (window.innerWidth >= 1024) this.isOpen = false;
            });
        },

        // Keep Tab inside the open panel instead of walking into the page behind it.
        trapFocus(event) {
            const nodes = this.$refs.menu?.querySelectorAll('a[href], button:not([disabled])');
            if (!nodes || !nodes.length) return;

            const first = nodes[0];
            const last = nodes[nodes.length - 1];

            if (event.shiftKey && document.activeElement === first) {
                event.preventDefault();
                last.focus();
            } else if (!event.shiftKey && document.activeElement === last) {
                event.preventDefault();
                first.focus();
            }
        }
    }"
    @keydown.escape.window="isOpen = false"
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

        $mobileNavLinks = [
            ['name' => 'Home', 'url' => '/'],
            ...$navLinks,
        ];
    @endphp

    <div class="absolute inset-0 transition-all duration-500 -z-10"
         :class="isScrolled ? 'bg-brand-light/95 backdrop-blur-sm border-b border-brand-green/20 shadow-sm' : 'bg-transparent'">
    </div>

    <div class="container mx-auto px-6 flex items-center justify-between transition-all duration-500 relative z-[60]"
         :class="isScrolled ? 'py-4' : 'py-6'">

        {{-- overflow-hidden is the safety net: min-w-0 lets this box shrink when the
             nav needs the room, but the brand text is nowrap and cannot shrink with
             it, so without clipping it spills straight over the nav links. Sized
             below to fit at every breakpoint; this only ever engages if a nav item
             is added later. --}}
        <a href="/" class="relative group flex items-center gap-2 sm:gap-3 min-w-0 overflow-hidden rounded-sm focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-orange focus-visible:ring-offset-2"
           aria-label="Mounts Edge Regency home">
            {{-- Both marks are stacked and cross-faded so the swap matches the navbar's own transition. --}}
            {{-- One mark, always green, no cross-fade: the mountain sits ON the orange
                 circle, not directly on the page, so its contrast comes from orange-vs-green
                 (always strong) rather than mark-vs-photo -- swapping it to cream over the
                 hero never bought anything and just meant the logo looked like a different
                 mark depending on scroll position. The navbar's own background still goes
                 transparent -> brand-light/95 on scroll; only the mark stopped moving. --}}
            {{-- Fluid height rather than h-9/h-11, so the mark grows on the same curve
                 as the wordmark beside it. At the old fixed 36px it towered over the
                 ~13px text on a phone; now the pair keeps a steady ratio from 320px up. --}}
            <span class="relative block h-[clamp(1.5rem,0.9rem_+_1.9vw,2.75rem)] aspect-[2204/1976] shrink-0">
                <x-logo variant="mark" alt="" class="absolute inset-0 h-full w-full object-contain" />
            </span>

            {{-- Fluid size instead of a fixed one: at 320px this reads ~12px and still
                 clears the hamburger with room to spare; it scales up to the old 24px
                 by tablet width and holds there. Used to be hidden below the sm breakpoint
                 entirely (the fixed 20px size collided with the hamburger at 320px) --
                 the mark shouldn't have to carry the brand alone on the smallest phones. --}}
            {{-- Note the underscores: Tailwind turns them into spaces, and CSS math
                 inside clamp() requires whitespace around the "+". Also caps at
                 1.375rem rather than 1.5rem -- at 24px the wordmark was 249px wide and,
                 with the nav needing 711px, the two together overflowed the row. --}}
            <span class="block whitespace-nowrap overflow-hidden text-ellipsis text-[clamp(0.875rem,0.5rem_+_1.6vw,1.375rem)] font-serif font-normal tracking-wide transition-colors duration-500"
                  :class="isScrolled || isOpen ? 'text-brand-green' : 'text-brand-light'">
                {{-- "Edge" is orange in the logo's wordmark, so it uses the mark's exact
                     orange in BOTH states -- the mark sits 12px away and any other orange
                     reads as a mismatch. WCAG 1.4.3 exempts brand names from the contrast
                     minimum for this reason; nav links and labels are not exempt and stay
                     on brand-ember. The weight bump echoes the logo, where EDGE is the
                     largest of the three words, and carries the lighter colour. --}}
                Mounts <span class="font-semibold text-brand-orange">Edge</span> Regency
            </span>
        </a>

        {{-- The nav appears at lg (1024px), which is also where space is tightest.
             gap-10 throughout cost 80px the row did not have; it returns at xl. --}}
        <div class="hidden lg:flex items-center gap-6 xl:gap-10">
            @foreach($navLinks as $link)
                <a href="{{ $link['url'] }}"
                   class="py-2 text-[11px] tracking-[0.15em] uppercase font-bold transition-colors duration-300 relative group rounded-sm focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-orange focus-visible:ring-offset-4"
                   :aria-current="currentPath === '{{ $link['url'] }}' ? 'page' : false"
                   :class="isScrolled ? (currentPath === '{{ $link['url'] }}' ? 'text-brand-ember' : 'text-brand-green hover:text-brand-ember') : (currentPath === '{{ $link['url'] }}' ? 'text-brand-orange' : 'text-brand-light/80 hover:text-brand-light')">
                    {{ $link['name'] }}

                    <span class="absolute bottom-0 left-0 w-full h-[1px] transition-transform duration-300 origin-left"
                          :class="currentPath === '{{ $link['url'] }}' ? 'scale-x-100 bg-brand-orange' : 'scale-x-0 bg-current group-hover:scale-x-100'">
                    </span>
                </a>
            @endforeach

            <a href="/contact"
               class="px-6 xl:px-8 py-4 text-[11px] tracking-[0.15em] uppercase font-bold transition-all duration-500 focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-orange focus-visible:ring-offset-2"
               :class="isScrolled
                    ? 'bg-brand-green text-brand-light hover:bg-brand-hover'
                    : 'bg-brand-light/10 border border-brand-light/30 text-brand-light hover:bg-brand-light hover:text-brand-green'">
                Book
            </a>
        </div>

        <button x-ref="toggle"
                @click="isOpen = !isOpen"
                class="lg:hidden p-2 rounded-sm focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-orange"
                :aria-label="isOpen ? 'Close menu' : 'Open menu'"
                :aria-expanded="isOpen ? 'true' : 'false'"
                aria-controls="mobile-menu">
            <svg x-show="!isOpen" aria-hidden="true" class="w-6 h-6 transition-colors duration-300" :class="isScrolled ? 'text-brand-green' : 'text-brand-light'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"></path></svg>

            <svg x-show="isOpen" aria-hidden="true" class="w-6 h-6 text-brand-green" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>

    <div x-ref="menu"
         id="mobile-menu"
         x-show="isOpen"
         @keydown.tab="trapFocus($event)"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[55] bg-brand-light lg:hidden overflow-y-auto"
         style="display: none;">
        <div class="min-h-full flex flex-col items-center justify-center gap-5 py-24 sm:gap-7">
            @foreach($mobileNavLinks as $index => $link)
                <div x-show="isOpen"
                     x-transition:enter="transition ease-out duration-500 delay-[{{ $index * 50 }}ms]"
                     x-transition:enter-start="opacity-0 translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0">
                    <a href="{{ $link['url'] }}"
                       @click="isOpen = false"
                       class="block px-4 py-2 text-2xl sm:text-3xl font-serif font-normal transition-colors duration-300 rounded-sm focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-orange"
                       :aria-current="currentPath === '{{ $link['url'] }}' ? 'page' : false"
                       :class="currentPath === '{{ $link['url'] }}' ? 'text-brand-ember' : 'text-brand-green hover:text-brand-ember'">
                         {{ $link['name'] }}
                    </a>
                </div>
            @endforeach

            <a href="/contact" @click="isOpen = false"
               class="mt-3 px-12 py-4 bg-brand-green text-brand-light text-[11px] tracking-[0.2em] uppercase font-bold hover:bg-brand-hover transition-colors sm:mt-5 sm:py-5 focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-orange focus-visible:ring-offset-2">
                Book Now
            </a>
        </div>
    </div>
</nav>
