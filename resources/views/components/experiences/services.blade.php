<section class="py-12 md:py-20 bg-white">
    <div class="container mx-auto px-6">
        <x-section-heading
            eyebrow="Hotel Services"
            title="Tours, Transport & Day-Outs"
            intro="Mounts Edge Regency arranges these services for guests. Each plan is customized around your dates, group, and interests." />

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">
            @php
                $services = [
                    [
                        'title' => 'Guest Transport',
                        'description' => 'Ask the team to arrange local transport for arrival and departure timing, day trips, and travel between the hotel and nearby towns.',
                        'points' => ['Arranged by the hotel team', 'Suited to your schedule', 'Confirmed before you travel'],
                    ],
                    [
                        'title' => 'Tours & Day-Outs',
                        'description' => 'Visit temples, lakes, waterfalls, viewpoints, and national parks around Mahiyangana with a plan customized for your group.',
                        'points' => ['Custom itinerary', 'Family and group friendly', 'Local knowledge from our team'],
                    ],
                    [
                        'title' => 'Event & Wedding Travel',
                        'description' => 'Coordinate guest movement for weddings and celebrations at the Grand Hall or Grand Lawn.',
                        'points' => ['Planned with your event', 'Group sizes welcome', 'Confirmed on request'],
                    ],
                ];
            @endphp

            @foreach ($services as $service)
                <div class="bg-brand-light border border-brand-green/10 p-6 md:p-8 flex flex-col">
                    <h3 class="text-xl md:text-2xl font-serif text-brand-green mb-4">{{ $service['title'] }}</h3>
                    <p class="text-brand-green/70 font-light leading-relaxed mb-6 flex-1">{{ $service['description'] }}</p>
                    <ul class="space-y-2 mb-0">
                        @foreach ($service['points'] as $point)
                            <li class="text-brand-green/70 text-sm font-light flex items-start gap-2">
                                <span class="text-brand-ember mt-0.5" aria-hidden="true">•</span>
                                <span>{{ $point }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>

        <div class="max-w-3xl mx-auto mt-10 md:mt-12 text-center">
            <p class="text-brand-green/70 font-light leading-relaxed text-sm md:text-base">
                These services are operated by Mounts Edge Regency, not by an outside partner. Arrangements are customized on request — there are no fixed packages, and cancellation and safety terms are confirmed with the team at the time of booking.
            </p>
        </div>
    </div>
</section>
