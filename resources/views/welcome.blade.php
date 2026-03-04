@extends('layouts.app')

<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')
    <x-home.hero-section />
    <x-home.experience-section />
    <x-home.why-choose-us />
    <x-home.signature-moments />
    <x-home.pool-highlight />
    <x-home.trust-bar />
    <x-cta-strip />
    <x-home.final-cta />
@endsection