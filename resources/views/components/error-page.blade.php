@props([
    'code',
    'title',
    'message',
    'actions' => [],
])

<section class="bg-brand-green text-brand-light">
    <div class="container mx-auto px-6 py-24 md:py-32 text-center">
        <p class="font-serif text-6xl md:text-8xl text-brand-orange leading-none mb-6">{{ $code }}</p>
        <h1 class="font-serif text-3xl md:text-5xl mb-4">{{ $title }}</h1>
        <p class="text-brand-cream/70 max-w-xl mx-auto font-light mb-10">{{ $message }}</p>

        <nav aria-label="Error recovery links" class="flex flex-col items-stretch justify-center gap-3 sm:flex-row sm:flex-wrap">
            @foreach ($actions as $action)
                <x-cta-button
                    :href="$action['href']"
                    :variant="$action['variant'] ?? 'outline-dark'"
                    class="{{ ($action['variant'] ?? '') === 'primary' ? 'w-full sm:w-auto' : '' }}">
                    {{ $action['label'] }}
                </x-cta-button>
            @endforeach
        </nav>
    </div>
</section>
