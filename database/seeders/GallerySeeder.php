<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GalleryCategory;
use App\Models\GalleryItem;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        // 1. Gallery Categories ටික හැදීම
        $catRooms = GalleryCategory::create(['name' => 'Rooms']);
        $catPool = GalleryCategory::create(['name' => 'Pool']);
        $catWeddings = GalleryCategory::create(['name' => 'Weddings']);
        $catFood = GalleryCategory::create(['name' => 'Food']);
        $catNature = GalleryCategory::create(['name' => 'Nature']);

        // 2. පින්තූර 12ක් Database එකට දැමීම
        $items = [
            ['cat' => $catRooms->id, 'img' => 'room1.jpg', 'desc' => 'Luxury suite bedroom'],
            ['cat' => $catPool->id, 'img' => 'pool1.jpg', 'desc' => 'Infinity pool at sunset'],
            ['cat' => $catWeddings->id, 'img' => 'wedding1.jpg', 'desc' => 'Wedding ceremony setup'],
            ['cat' => $catFood->id, 'img' => 'food1.jpg', 'desc' => 'Authentic Sri Lankan cuisine'],
            ['cat' => $catNature->id, 'img' => 'nature1.jpg', 'desc' => 'Misty sunrise'],
            ['cat' => $catRooms->id, 'img' => 'room2.jpg', 'desc' => 'Deluxe room interior'],
            ['cat' => $catWeddings->id, 'img' => 'wedding2.jpg', 'desc' => 'Grand wedding reception'],
            ['cat' => $catFood->id, 'img' => 'food2.jpg', 'desc' => 'Fine dining experience'],
            ['cat' => $catPool->id, 'img' => 'pool2.jpg', 'desc' => 'Night view of the pool'],
            ['cat' => $catNature->id, 'img' => 'nature2.jpg', 'desc' => 'Lush green garden view'],
            ['cat' => $catRooms->id, 'img' => 'room3.jpg', 'desc' => 'Romance, Comfort, and Soft Light. Celebrate Love in Luxury'],
            ['cat' => $catWeddings->id, 'img' => 'wedding3.jpg', 'desc' => 'Beautiful bridal setup'],
        ];

        foreach ($items as $item) {
            GalleryItem::create([
                'gallery_category_id' => $item['cat'],
                'image' => '/storage/gallery/' . $item['img'],
                'description' => $item['desc']
            ]);
        }
    }
}