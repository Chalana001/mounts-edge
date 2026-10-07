@extends('layouts.app')

@section('content')
    <x-dining.hero />
    <x-seo-intro :seo="$seo" />
    <x-dining.atmosphere />
    <x-dining.signature-dishes />
    <x-dining.bar-section />
    <x-dining.dining-spaces />
    <x-seo-faq :seo="$seo" />
    <x-dining.reserve-cta />
    <x-dining.wedding-cta />
@endsection