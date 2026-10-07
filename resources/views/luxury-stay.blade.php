@extends('layouts.app')

@section('content')
    <x-rooms.hero />
    <x-seo-intro :seo="$seo" />
    <x-rooms.room-tabs :roomTypes="$roomTypes" :firstTab="$firstTab" />
    <x-rooms.pool-relaxation />
    <x-rooms.amenities />
    <x-seo-faq :seo="$seo" />
    <x-rooms.booking-cta />
    
    @endsection