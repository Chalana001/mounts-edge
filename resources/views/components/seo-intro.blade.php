@props(['seo'])

{{-- Intro: one crawlable paragraph under the H1 hero, same facts as meta. --}}
<section class="bg-white border-b border-brand-green/10">
    <div class="container mx-auto px-6 py-8 md:py-10 max-w-4xl text-center">
        <h2 class="sr-only">{{ $seo['h1'] }}</h2>
        <p class="text-brand-green/80 font-light leading-relaxed text-[15px] md:text-base">{{ $seo['intro'] }}</p>
    </div>
</section>