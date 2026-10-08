@extends('layouts.app')

@section('page.title', 'Something Went Wrong | Mounts Edge Regency')
@section('page.robots', 'noindex, follow')

@section('content')
    <section class="bg-brand-green text-brand-light">
        <div class="container mx-auto px-6 py-24 md:py-32 text-center">
            <p class="font-serif text-6xl md:text-8xl text-brand-orange leading-none mb-6">500</p>
            <h1 class="font-serif text-3xl md:text-5xl mb-4">Something went wrong on our side</h1>
            <p class="text-brand-cream/70 max-w-xl mx-auto font-light mb-10">
                The error has been logged and we'll look into it. Please try again in a little while.
            </p>

            <a href="{{ route('home') }}"
               class="inline-block bg-brand-light text-brand-green hover:bg-brand-cream px-8 py-4 text-[11px] tracking-[0.2em] uppercase font-bold transition-colors">
                Back to Home
            </a>
        </div>
    </section>
@endsection
