<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WeddingHall;
use App\Models\WeddingPackage;
use App\Models\WeddingCatering;
use App\Models\WeddingDecoration;

class WeddingController extends Controller
{
    public function index()
    {
        // 1. Database එකේ Models වලින් ඩේටා ටික ගන්නවා
        $halls = WeddingHall::all(); // මෙතන all() කරලා $halls කියලා ගත්තා
        $packages = WeddingPackage::all();
        $catering = WeddingCatering::first();
        $decoration = WeddingDecoration::first();

        // 2. Blade එකට අවශ්‍ය $tabs Array එක සකස් කිරීම
        $tabs = [
            'hall' => [
                'label' => 'Wedding Halls',
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-building"><rect x="4" y="2" width="16" height="20" rx="2" ry="2"></rect><path d="M9 22v-4h6v4"></path><path d="M8 6h.01"></path><path d="M16 6h.01"></path><path d="M12 6h.01"></path><path d="M12 10h.01"></path><path d="M12 14h.01"></path><path d="M16 10h.01"></path><path d="M16 14h.01"></path><path d="M8 10h.01"></path><path d="M8 14h.01"></path></svg>',
                
                // අලුත් type එකක් දුන්නා ලූප් කරන්න පුළුවන් වෙන්න
                'type' => 'multi-split', 
                
                // Halls ඔක්කොම ලූප් කරලා Array එකකට දානවා
                'items' => $halls->map(function($hall) {
                    return [
                        'title' => $hall->name,
                        'tagline' => $hall->tagline,
                        'desc' => $hall->description,
                        'image' => $hall->image ? asset($hall->image) : 'https://images.unsplash.com/photo-1464366400600-7168b8af9bc3?w=800&q=80',
                        'details' => [
                            ['label' => 'Capacity', 'value' => $hall->capacity ?? 'N/A'],
                            ['label' => 'Area', 'value' => $hall->area ?? 'N/A'],
                            ['label' => 'Style', 'value' => $hall->style ?? 'N/A'],
                        ],
                        'tags' => $hall->features ?? []
                    ];
                })->toArray()
            ],
            'packages' => [
                'label' => 'Wedding Packages',
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-package"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>',
                'type' => 'grid',
                'title' => 'Wedding Packages',
                'tagline' => 'All-Inclusive Options',
                'desc' => 'Choose from our carefully curated wedding packages.',
                'items' => $packages->map(function($pkg) {
                    return [
                        'name' => $pkg->name, 
                        'guests' => $pkg->guests, 
                        'includes' => $pkg->includes ?? [], 
                        'popular' => $pkg->is_popular
                    ];
                })->toArray()
            ],
            'catering' => [
                'label' => 'Catering & Menu',
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chef-hat"><path d="M6 13.87A4 4 0 0 1 7.41 6a5.11 5.11 0 0 1 1.05-1.54 5 5 0 0 1 7.08 0A5.11 5.11 0 0 1 16.59 6 4 4 0 0 1 18 13.87V21H6Z"></path><line x1="6" y1="17" x2="18" y2="17"></line></svg>',
                'type' => 'split',
                'title' => $catering?->name ?? 'Catering & Menu',
                'tagline' => $catering?->tagline ?? 'Culinary Excellence',
                'desc' => $catering?->description ?? 'Description not available.',
                'image' => $catering?->image ? asset($catering->image) : 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=800&q=80',
                'list_title' => $catering?->list_title ?? 'Menu Options',
                'list_items' => $catering?->list_items ?? [],
                'tags' => $catering?->tags ?? []
            ],
            'decorations' => [
                'label' => 'Decorations',
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-palette"><circle cx="13.5" cy="6.5" r=".5"></circle><circle cx="17.5" cy="10.5" r=".5"></circle><circle cx="8.5" cy="7.5" r=".5"></circle><circle cx="6.5" cy="12.5" r=".5"></circle><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z"></path></svg>',
                'type' => 'split',
                'title' => $decoration?->name ?? 'Decorations',
                'tagline' => $decoration?->tagline ?? 'Your Vision, Our Art',
                'desc' => $decoration?->description ?? 'Description not available.',
                'image' => $decoration?->image ? asset($decoration->image) : 'https://images.unsplash.com/photo-1478146896981-b80fe463b330?w=800&q=80',
                'list_title' => $decoration?->list_title ?? 'Decoration Styles',
                'list_items' => $decoration?->list_items ?? [],
                'tags' => $decoration?->tags ?? []
            ]
        ];

        return view('weddings', compact('tabs'));
    }
}