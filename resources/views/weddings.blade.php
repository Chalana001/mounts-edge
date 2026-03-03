@extends('layouts.app')

@section('content')
    <x-weddings.hero />
    <x-weddings.tabs-section :tabs="$tabs" />
    <x-weddings.photo-spots />
    <x-weddings.testimonial />
    <x-weddings.whatsapp-cta />
    
    @endsection