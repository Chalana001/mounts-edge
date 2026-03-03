<section class="relative h-screen w-full overflow-hidden bg-brand-green" 
    x-data="{ shown: false }" 
    x-init="setTimeout(() => shown = true, 100)">

    <div class="absolute inset-0 z-0">
        <div class="absolute inset-0 bg-cover bg-center transition-transform duration-[10s] ease-in-out transform scale-100 hover:scale-105"
             style="background-image: url('/storage/home/mounts-edge-regency.jpg');">
        </div>
        <div class="absolute inset-0 bg-black/40"></div>
    </div>

    <div class="relative z-10 flex h-full flex-col items-center justify-center px-6 text-center">
        
        <div x-show="shown"
             x-transition:enter="transition ease-out duration-1000 delay-300"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="mb-6">
            <span class="text-[#F5F5DC]/90 font-sans text-xs tracking-[0.4em] uppercase font-light drop-shadow-md">
                Gurulupotha · Mahiyangana · Sri Lanka
            </span>
        </div>

        <h1 x-show="shown"
            x-transition:enter="transition ease-out duration-1000 delay-500"
            x-transition:enter-start="opacity-0 translate-y-8"
            x-transition:enter-end="opacity-100 translate-y-0"
            class="max-w-4xl text-5xl md:text-7xl lg:text-8xl font-serif font-normal text-brand-light leading-[1.1] tracking-tight drop-shadow-xl">
            Mounts Edge Regency
        </h1>

        <div x-show="shown"
             x-transition:enter="transition ease-out duration-1000 delay-700"
             x-transition:enter-start="opacity-0 scale-x-0"
             x-transition:enter-end="opacity-100 scale-x-100"
             class="w-16 h-[1px] bg-brand-orange my-10">
        </div>

        <p x-show="shown"
           x-transition:enter="transition ease-out duration-1000 delay-1000"
           x-transition:enter-start="opacity-0 translate-y-4"
           x-transition:enter-end="opacity-100 translate-y-0"
           class="max-w-md text-[#F5F5DC]/80 text-base md:text-lg font-light leading-relaxed mb-12">
            A mountain retreat where stillness meets celebration
        </p>

        <div x-show="shown"
             x-transition:enter="transition ease-out duration-1000 delay-[1200ms]"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="flex flex-col sm:flex-row gap-6">
            
            <a href="/luxury-stay" 
               class="px-10 py-5 text-sm font-light tracking-[0.15em] uppercase border border-[#F5F5DC]/30 text-[#F5F5DC] 
                      hover:bg-[#F5F5DC] hover:text-brand-green transition-all duration-500 rounded-none">
                Stay
            </a>

            <a href="/weddings" 
               class="px-10 py-5 text-sm font-light tracking-[0.15em] uppercase bg-[#F5F5DC] text-brand-green
                      hover:bg-brand-orange hover:text-brand-light transition-all duration-500 rounded-none">
                Celebrate
            </a>
        </div>
    </div>

    <div x-show="shown"
         x-transition:enter="transition ease-in duration-1000 delay-[2000ms]"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         class="absolute bottom-12 left-1/2 -translate-x-1/2 z-10">
        
        <div class="w-[1px] h-16 bg-gradient-to-b from-[#F5F5DC]/50 to-transparent animate-scroll-flow"></div>
    </div>

    <style>
        @keyframes scroll-flow {
            0% { transform: translateY(0); opacity: 1; }
            50% { transform: translateY(10px); opacity: 0.5; }
            100% { transform: translateY(0); opacity: 1; }
        }
        .animate-scroll-flow {
            animation: scroll-flow 2s infinite ease-in-out;
        }
    </style>
</section>