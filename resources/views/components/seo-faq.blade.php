@props(['seo'])

{{-- Visible FAQ answers the schema FAQPage; keep answers short and factual. --}}
@if (! empty($seo['faq']))
<section class="bg-white border-t border-brand-green/10" aria-label="Frequently asked questions">
    <div class="container mx-auto px-6 py-10 md:py-14 max-w-3xl">
        <h2 class="font-serif text-2xl md:text-3xl text-brand-green text-center mb-6">Good to know</h2>
        <div class="space-y-5">
            @foreach ($seo['faq'] as $item)
                <div class="border border-brand-green/15 bg-brand-light/50 px-5 py-4">
                    <h3 class="font-bold text-brand-green text-sm md:text-base">{{ $item['q'] }}</h3>
                    <p class="mt-1 text-brand-green/75 font-light text-sm leading-relaxed">{{ $item['a'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
