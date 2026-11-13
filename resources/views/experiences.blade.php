@extends('layouts.app')

@section('content')
    <x-experiences.hero />
    <x-seo-intro :seo="$seo" />
    <x-experiences.services />
    <x-experiences.attractions />
    <x-experiences.knuckles-highlight />
    <x-experiences.nearby-highlights />
    <x-seo-faq :seo="$seo" />
    <x-experiences.cta />
@endsection
