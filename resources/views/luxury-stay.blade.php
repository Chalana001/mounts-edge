@extends('layouts.app')

@section('content')
    <x-rooms.hero />
    <x-rooms.room-tabs :roomTypes="$roomTypes" :firstTab="$firstTab" />
    <x-rooms.pool-relaxation />
    <x-rooms.amenities />
    <x-rooms.booking-cta />
    
    @endsection