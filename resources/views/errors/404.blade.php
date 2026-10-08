@extends('layouts.app')

@section('page.title', 'Page Not Found | Mounts Edge Regency')
@section('page.robots', 'noindex, follow')

@section('content')
    <x-error-page
        code="404"
        title="This page has checked out"
        message="The page you're looking for doesn't exist. It may have moved, or the link might be mistyped. Here are some places you can go instead."
        :actions="[
            ['label' => 'Rooms', 'href' => route('luxury-stay'), 'variant' => 'primary'],
            ['label' => 'Weddings', 'href' => route('weddings')],
            ['label' => 'Dining', 'href' => route('dining')],
            ['label' => 'Gallery', 'href' => route('gallery')],
            ['label' => 'Contact', 'href' => route('contact')],
        ]" />
@endsection
