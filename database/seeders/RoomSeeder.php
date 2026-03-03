<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RoomType;
use App\Models\Room;
use App\Models\Feature;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Deluxe Type & Room
        $deluxeType = RoomType::create([
            'slug' => 'deluxe',
            'name' => 'Deluxe Rooms',
            'icon' => 'M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z'
        ]);

        $deluxeRoom = Room::create([
            'room_type_id' => $deluxeType->id,
            'name' => 'Deluxe Rooms',
            'tagline' => 'Comfort Meets Elegance',
            'description' => 'Our Deluxe Rooms offer the perfect blend of comfort and style, featuring modern amenities with stunning mountain views from your private balcony.',
            'image' => '/storage/rooms/deluxe.jpg', 
            'capacity' => '2 Adults',
            'size' => '32 sqm',
        ]);
        
        $deluxeFeatures = ['King/Twin Beds', 'Mountain View', 'Private Balcony', 'AC', 'Free WiFi'];
        foreach ($deluxeFeatures as $featureName) {
            $feature = Feature::firstOrCreate(['name' => $featureName]);
            $deluxeRoom->features()->attach($feature->id);
        }

        // 2. Family Type & Room
        $familyType = RoomType::create([
            'slug' => 'family',
            'name' => 'Family Rooms',
            'icon' => 'M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2 M9 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0z'
        ]);

        $familyRoom = Room::create([
            'room_type_id' => $familyType->id,
            'name' => 'Family Rooms',
            'tagline' => 'Space for Everyone',
            'description' => 'Spacious family rooms designed for memorable getaways with your loved ones. Enjoy separate sleeping areas and a cozy living space.',
            'image' => '/storage/rooms/family.jpg', 
            'capacity' => '4 Adults + 2 Kids',
            'size' => '55 sqm',
        ]);

        $familyFeatures = ['Multiple Beds', 'Living Area', 'Garden View', 'AC', 'Mini Bar'];
        foreach ($familyFeatures as $featureName) {
            $feature = Feature::firstOrCreate(['name' => $featureName]);
            $familyRoom->features()->attach($feature->id);
        }

        // 3. Villa Type & Room
        $villaType = RoomType::create([
            'slug' => 'villa',
            'name' => 'Villa Experience',
            'icon' => 'M3 21h18 M3 7v1h18V7 M5 21V8 M9 21V8 M15 21V8 M19 21V8 M2 4h20 M12 2 2 7h20z'
        ]);

        $villaRoom = Room::create([
            'room_type_id' => $villaType->id,
            'name' => 'Villa Experience',
            'tagline' => 'Ultimate Privacy & Luxury',
            'description' => 'Experience unparalleled luxury in our exclusive villa, featuring a private pool, panoramic views, and personalized butler service.',
            'image' => '/storage/rooms/villa.jpg', 
            'capacity' => '6 Adults',
            'size' => '120 sqm',
        ]);

        $villaFeatures = ['Private Pool', 'Panoramic View', 'Butler Service', 'Full Kitchen'];
        foreach ($villaFeatures as $featureName) {
            $feature = Feature::firstOrCreate(['name' => $featureName]);
            $villaRoom->features()->attach($feature->id);
        }
    }
}