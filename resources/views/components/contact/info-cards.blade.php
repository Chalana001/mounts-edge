<section class="py-20 bg-[#f9f9f7]">
    <div class="container mx-auto px-6">
        @php
            $info = [
                ['title' => 'Address', 'lines' => ['Gurulupotha, Hasalaka', 'Mahiyangana, Sri Lanka'], 'icon' => 'M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z'],
                ['title' => 'Phone', 'lines' => ['055 2 256 500'], 'icon' => 'M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6'],
                ['title' => 'Email', 'lines' => ['ckalhara7277@gmail.com'], 'icon' => 'M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z'],
                ['title' => 'Hours', 'lines' => ['Open 24 Hours', 'Check-in: 2:00 PM'], 'icon' => 'M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0z'],
            ];
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-12 max-w-6xl mx-auto">
            @foreach($info as $item)
                <div class="text-center group">
                    <div class="w-12 h-12 mx-auto mb-6 border border-brand-green/30 flex items-center justify-center text-brand-green group-hover:bg-brand-green group-hover:text-brand-light transition-all duration-500">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="{{ $item['icon'] }}"></path>
                        </svg>
                    </div>
                    <h3 class="font-serif text-brand-green text-lg mb-3">{{ $item['title'] }}</h3>
                    @foreach($item['lines'] as $line)
                        <p class="text-brand-green/70 text-sm font-light italic leading-relaxed">{{ $line }}</p>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
</section>