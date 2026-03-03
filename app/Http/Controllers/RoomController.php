<?php

namespace App\Http\Controllers;

use App\Models\RoomType;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $roomTypes = RoomType::with(['rooms.features'])->get();
        $firstTab = $roomTypes->first()->slug ?? 'deluxe';

        return view('luxury-stay', compact('roomTypes', 'firstTab'));
    }
}