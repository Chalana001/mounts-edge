<x-container-section padding="compact" class="bg-brand-orange/5 border-y border-brand-orange/20">
        <div class="flex flex-col md:flex-row items-center justify-center gap-8 md:gap-12">
            <p class="text-brand-green/70 font-light text-sm md:text-base text-center max-w-xl">
                Seen something you like? Explore our <x-surface-link href="{{ route('luxury-stay') }}">rooms</x-surface-link> and <x-surface-link href="{{ route('experiences') }}">nearby experiences</x-surface-link>, or enquire directly.
            </p>

            <x-cta-button href="{{ route('contact', ['type' => \App\Models\Enquiry::TYPE_ROOM]) }}">
                Check Availability
            </x-cta-button>
        </div>
</x-container-section>
