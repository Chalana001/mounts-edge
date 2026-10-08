@extends('layouts.app')

@section('page.title', 'Page Not Found | Mounts Edge Regency')
@section('page.robots', 'noindex, follow')

@section('content')
    <section class="bg-brand-green text-brand-light">
        <div class="container mx-auto px-6 py-24 md:py-32 text-center">
            <p class="font-serif text-6xl md:text-8xl text-brand-orange leading-none mb-6">404</p>
            <h1 class="font-serif text-3xl md:text-5xl mb-4">This page has checked out</h1>
            <p class="text-brand-cream/70 max-w-xl mx-auto font-light mb-10">
                The page you're looking for doesn't exist. It may have moved, or the link might be mistyped.
                Here are some places you can go instead.
            </p>

            <nav aria-label="Site sections" class="flex flex-wrap items-center justify-center gap-3">
                <a href="{{ route('luxury-stay') }}"
                   class="bg-brand-light text-brand-green hover:bg-brand-cream px-8 py-4 text-[11px] tracking-[0.2em] uppercase font-bold transition-colors">
                    Rooms
                </a>
                <a href="{{ route('weddings') }}"
                   class="border border-brand-cream/60 text-brand-light hover:border-brand-orange hover:text-brand-orange px-8 py-4 text-[11px] tracking-[0.2em] uppercase font-bold transition-colors">
                    Weddings
                </a>
                <a href="{{ route('dining') }}"
                   class="border border-brand-cream/60 text-brand-light hover:border-brand-orange hover:text-brand-orange px-8 py-4 text-[11px] tracking-[0.2em] uppercase font-bold transition-colors">
                    Dining
                </a>
                <a href="{{ route('gallery') }}"
                   class="border border-brand-cream/60 text-brand-light hover:border-brand-orange hover:text-brand-orange px-8 py-4 text-[11px] tracking-[0.2em] uppercase font-bold transition-colors">
                    Gallery
                </a>
                <a href="{{ route('contact') }}"
                   class="border border-brand-cream/60 text-brand-light hover:border-brand-orange hover:text-brand-orange px-8 py-4 text-[11px] tracking-[0.2em] uppercase font-bold transition-colors">
                    Contact
                </a>
            </nav>
        </div>
    </section>
@endsection
