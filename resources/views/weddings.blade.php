@extends('layouts.app')

@section('content')
    <x-weddings.hero />
    <x-seo-intro :seo="$seo" />
    <x-weddings.tabs-section :tabs="$tabs" />
    <x-weddings.photo-spots />
    <x-weddings.testimonial />
    <x-seo-faq :seo="$seo" />
    <x-weddings.whatsapp-cta />
    
    @endsection