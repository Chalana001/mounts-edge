<footer class="bg-brand-green text-brand-cream">
    <div class="container mx-auto px-6 py-12 md:py-16">
        <div class="max-w-4xl mx-auto text-center">
            <a href="/" class="inline-block mb-8" aria-label="Mounts Edge Regency — home">
                {{-- Stacked lockup: below ~h-32 the wordmark stops being legible. --}}
                <x-logo variant="wordmark" light class="h-16 w-auto mx-auto md:h-20" />
            </a>
            
            <p class="text-brand-cream/70 text-sm font-light leading-relaxed mb-10 max-w-md mx-auto">
                A hotel on Kandy Rd, Gurulupotha, Hasalaka 20960, near Mahiyangana — for stays, weddings, dining, and day-outs.
            </p>

            {{-- mb-10 matches the tagline above and the contact block below, so the
                 three stack on an even rhythm. An orange rule used to sit here and
                 justified a wider gap; without it, the extra space just read as a hole. --}}
            <nav class="flex flex-wrap justify-center gap-8 mb-10">
                @php
                    $footerLinks = [
                        ['name' => 'Stay', 'path' => '/luxury-stay'],
                        ['name' => 'Weddings', 'path' => '/weddings'],
                        ['name' => 'Dining', 'path' => '/dining'],
                        ['name' => 'Experiences', 'path' => '/experiences'],
                        ['name' => 'Gallery', 'path' => '/gallery'],
                        ['name' => 'Contact', 'path' => '/contact'],
                    ];
                @endphp

                @foreach($footerLinks as $link)
                    <a href="{{ $link['path'] }}" 
                       class="text-brand-cream/70 hover:text-brand-orange text-[11px] tracking-[0.2em] uppercase font-bold transition-colors duration-300 py-2">
                        {{ $link['name'] }}
                    </a>
                @endforeach
            </nav>

            <div class="space-y-3 text-brand-cream/70 text-xs tracking-wide font-light mb-10">
                <p class="hover:text-brand-cream transition-colors cursor-default" itemprop="address">{{ $siteSettings->address }}</p>
                <p><a href="tel:{{ $siteSettings->phone_link }}" data-conversion="contact_phone_click" class="inline-block py-1 hover:text-brand-cream transition-colors">{{ $siteSettings->phone_display }}</a></p>
                <p><a href="mailto:{{ $siteSettings->public_email }}" data-conversion="contact_email_click" class="inline-block py-1 hover:text-brand-cream transition-colors">{{ $siteSettings->public_email }}</a></p>
            </div>
        </div>

        <div class="border-t border-brand-cream/10 pt-8 text-center">
            <p class="text-brand-cream/70 text-[11px] tracking-widest uppercase font-light">
                &copy; {{ date('Y') }} Mounts Edge Regency. All Rights Reserved.
            </p>
        </div>
    </div>
</footer>
