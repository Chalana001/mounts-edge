<?php

namespace App\Http\Controllers;

use App\Models\GalleryCategory;
use App\Models\GalleryItem;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $categories = GalleryCategory::all();
        $galleryItems = GalleryItem::with('category')->latest()->get();

        return view('gallery', compact('categories', 'galleryItems'));
    }
}