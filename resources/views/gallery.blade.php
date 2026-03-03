@extends('layouts.app') @section('content')
    <x-gallery.hero /> 
    
    <x-gallery.grid :categories="$categories" :galleryItems="$galleryItems" />
    
    <x-cta-strip />
@endsection