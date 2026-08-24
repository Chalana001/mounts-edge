@extends('layouts.app')

@section('content')
    <x-contact.hero />
    <x-contact.quick-actions />
    <x-contact.info-cards />
    <x-contact.form
        :room-types="$roomTypes"
        :wedding-halls="$weddingHalls"
        :wedding-packages="$weddingPackages"
        :preselected-type="$preselectedType"
        :preselected-room-type="$preselectedRoomType"
        :preselected-hall="$preselectedHall"
    />
    <x-contact.map />
@endsection
