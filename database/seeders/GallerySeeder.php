<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GalleryCategory;
use App\Models\GalleryItem;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        $catRooms = GalleryCategory::create(['name' => 'Rooms']);
        $catPool = GalleryCategory::create(['name' => 'Pool']);
        $catWeddings = GalleryCategory::create(['name' => 'Weddings']);
        $catFood = GalleryCategory::create(['name' => 'Food']);
        $catNature = GalleryCategory::create(['name' => 'Nature']);

        $items = [
            ['cat' => $catRooms->id, 'img' => 'room1.jpg', 'desc' => 'Suite bedroom'],
            ['cat' => $catPool->id, 'img' => 'pool1.jpg', 'desc' => 'Infinity pool, late afternoon'],
            ['cat' => $catWeddings->id, 'img' => 'wedding1.jpg', 'desc' => 'Ceremony setup'],
            ['cat' => $catFood->id, 'img' => 'food1.jpg', 'desc' => 'Sri Lankan rice and curry'],
            ['cat' => $catNature->id, 'img' => 'nature1.jpg', 'desc' => 'Sunrise over the valley'],
            ['cat' => $catRooms->id, 'img' => 'room2.jpg', 'desc' => 'Deluxe room'],
            ['cat' => $catWeddings->id, 'img' => 'wedding2.jpg', 'desc' => 'Reception hall'],
            ['cat' => $catFood->id, 'img' => 'food2.jpg', 'desc' => 'Table setting'],
            ['cat' => $catPool->id, 'img' => 'pool2.jpg', 'desc' => 'Pool at night'],
            ['cat' => $catNature->id, 'img' => 'nature2.jpg', 'desc' => 'The garden'],
            ['cat' => $catRooms->id, 'img' => 'room3.jpg', 'desc' => 'Twin room, evening light'],
            ['cat' => $catWeddings->id, 'img' => 'wedding3.jpg', 'desc' => 'Bridal room'],
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