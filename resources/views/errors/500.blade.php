@extends('layouts.app')

@section('page.title', 'Something Went Wrong | Mounts Edge Regency')
@section('page.robots', 'noindex, follow')

@section('content')
    <x-error-page
        code="500"
        title="Something went wrong on our side"
        message="The error has been logged and we'll look into it. Please try again in a little while."
        :actions="[['label' => 'Back to Home', 'href' => route('home'), 'variant' => 'primary']]" />
@endsection
