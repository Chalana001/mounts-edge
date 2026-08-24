<section class="py-12 md:py-20 bg-white">
    <div class="container mx-auto px-6">
        @php
            // Each icon is a list of SVG paths: the phone and mail glyphs need
            // more than one path, so a single-path shape renders incomplete.
            $info = [
                [
                    'title' => 'Address',
                    'lines' => [$siteSettings->address],
                    'url' => $siteSettings->map_url,
                    'external' => true,
                    'paths' => [
                        'M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z',
                        'M15 10a3 3 0 1 1-6 0 3 3 0 0 1 6 0z',
                    ],
                ],
                [
                    'title' => 'Phone',
                    'lines' => [$siteSettings->phone_display],
                    'url' => 'tel:'.$siteSettings->phone_link,
                    'paths' => [
                        'M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z',
                    ],
                ],
                [
                    'title' => 'Email',
                    'lines' => [$siteSettings->public_email],
                    'url' => 'mailto:'.$siteSettings->public_email,
                    'paths' => [
                        'M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z',
                        'M22 6l-10 7L2 6',
                    ],
                ],
                [
                    'title' => 'Hours',
                    'lines' => ['Open 24 Hours', 'Check-in: 2:00 PM'],
                    'paths' => [
                        'M12 8v4l3 3',
                        'M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z',
                    ],
                ],
            ];
        @endphp

        <div class="grid grid-cols-4 gap-2 sm:gap-6 lg:gap-12 max-w-6xl mx-auto">
            @foreach($info as $item)
                <div class="text-center group">
                    <div class="w-9 h-9 md:w-12 md:h-12 mx-auto mb-2 md:mb-6 border border-brand-green/30 flex items-center justify-center text-brand-green group-hover:bg-brand-green group-hover:text-brand-light transition-all duration-500">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"
                             class="w-4 h-4 md:w-5 md:h-5">
                            @foreach($item['paths'] as $path)
                                <path d="{{ $path }}"></path>
                            @endforeach
                        </svg>
                    </div>
                    <h3 class="font-serif text-brand-green text-[11px] md:text-lg mb-1 md:mb-3">{{ $item['title'] }}</h3>

                    @php $lineClass = 'text-brand-green/70 text-[9px] md:text-sm font-light italic leading-snug md:leading-relaxed break-words'; @endphp

                    @if(! empty($item['url']))
                        {{-- Tap to call / email / open directions. --}}
                        <a href="{{ $item['url'] }}"
                           @if(! empty($item['external'])) target="_blank" rel="noopener" @endif
                           class="block hover:text-brand-orange transition-colors">
                            @foreach($item['lines'] as $line)
                                <span class="{{ $lineClass }} block">{{ $line }}</span>
                            @endforeach
                        </a>
                    @else
                        @foreach($item['lines'] as $line)
                            <p class="{{ $lineClass }}">{{ $line }}</p>
                        @endforeach
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>
