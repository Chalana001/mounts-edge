@extends('layouts.app')

@section('page.title', 'Access Restricted | Mounts Edge Regency')
@section('page.robots', 'noindex, follow')

@section('content')
    <x-error-page
        code="403"
        title="You don't have access to this page"
        message="If you believe you should be able to see this, contact the site administrator."
        :actions="[['label' => 'Back to Home', 'href' => route('home'), 'variant' => 'primary']]" />
@endsection
