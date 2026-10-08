<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GalleryCategory;
use App\Models\GalleryItem;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        $catRooms = GalleryCategory::firstOrCreate(['name' => 'Rooms']);
        $catPool = GalleryCategory::firstOrCreate(['name' => 'Pool']);
        $catWeddings = GalleryCategory::firstOrCreate(['name' => 'Weddings']);
        $catFood = GalleryCategory::firstOrCreate(['name' => 'Food']);
        $catNature = GalleryCategory::firstOrCreate(['name' => 'Nature']);

        // Descriptions double as alt text (GalleryItem::altText()) and as the
        // lightbox caption — factual, unique per photo, hotel-named for entity
        // context in image search.
        $items = [
            ['cat' => $catRooms->id, 'img' => 'room1.jpg', 'desc' => 'Suite bedroom with warm lighting at Mounts Edge Regency'],
            ['cat' => $catPool->id, 'img' => 'pool1.jpg', 'desc' => 'The infinity pool at Mounts Edge Regency in late afternoon light'],
            ['cat' => $catWeddings->id, 'img' => 'wedding1.jpg', 'desc' => 'Wedding ceremony setup at Mounts Edge Regency'],
            ['cat' => $catFood->id, 'img' => 'food1.jpg', 'desc' => 'Sri Lankan rice and curry served at Mounts Edge Regency'],
            ['cat' => $catNature->id, 'img' => 'nature1.jpg', 'desc' => 'Sunrise over the valley seen from Mounts Edge Regency'],
            ['cat' => $catRooms->id, 'img' => 'room2.jpg', 'desc' => 'Deluxe room interior at Mounts Edge Regency'],
            ['cat' => $catWeddings->id, 'img' => 'wedding2.jpg', 'desc' => 'Wedding reception hall at Mounts Edge Regency'],
            ['cat' => $catFood->id, 'img' => 'food2.jpg', 'desc' => 'Table setting in the restaurant at Mounts Edge Regency'],
            ['cat' => $catPool->id, 'img' => 'pool2.jpg', 'desc' => 'The infinity pool at Mounts Edge Regency lit at night'],
            ['cat' => $catNature->id, 'img' => 'nature2.jpg', 'desc' => 'The garden and grounds of Mounts Edge Regency'],
            ['cat' => $catRooms->id, 'img' => 'room3.jpg', 'desc' => 'Twin room in evening light at Mounts Edge Regency'],
            ['cat' => $catWeddings->id, 'img' => 'wedding3.jpg', 'desc' => 'Bridal dressing room prepared for a wedding at Mounts Edge Regency'],
        ];

        foreach ($items as $item) {
            GalleryItem::firstOrCreate(
                ['image' => '/storage/gallery/' . $item['img']],
                [
                    'gallery_category_id' => $item['cat'],
                    'description' => $item['desc'],
                ]
            );
        }
    }
}