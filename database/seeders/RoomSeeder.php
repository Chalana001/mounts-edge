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
        // Owner-confirmed 2026-10-07: current inventory is all-Deluxe plus a
        // Family Suite — no Standard rooms. Rates exist in four tiers per
        // room (docs/BUSINESS-TRUTH.md §3) but are deliberately NOT seeded:
        // the site is enquiry-only and prices stay on the OTA.
        $deluxeType = RoomType::firstOrCreate(
            ['slug' => 'deluxe'],
            ['name' => 'Deluxe Rooms', 'icon' => 'M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z']
        );
        $suiteType = RoomType::firstOrCreate(
            ['slug' => 'family-suite'],
            ['name' => 'Family Suites', 'icon' => 'M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z']
        );

        $rooms = [
            [
                'room_type_id' => $deluxeType->id,
                'name' => 'Deluxe Single Room',
                'tagline' => 'Smart comfort for solo travellers',
                'description' => 'A Deluxe Single Room with 1 large double bed for 1 guest. Enquire for availability and rates.',
                'image' => '/storage/rooms/deluxe.jpg',
                'images' => ['/storage/rooms/deluxe.jpg'],
                'capacity' => '1 guest',
                'size' => '1 large double bed',
                'features' => ['AC', 'Free WiFi', 'Mountain View'],
            ],
            [
                'room_type_id' => $deluxeType->id,
                'name' => 'Deluxe Double Room',
                'tagline' => 'Comfort meets elegance',
                'description' => 'A Deluxe Double Room with 2 large double beds for 2 guests, with mountain views. Enquire for availability and rates.',
                'image' => '/storage/rooms/deluxe.jpg',
                'images' => ['/storage/rooms/deluxe.jpg'],
                'capacity' => '2 guests',
                'size' => '2 large double beds',
                'features' => ['Mountain View', 'AC', 'Free WiFi'],
            ],
            [
                'room_type_id' => $deluxeType->id,
                'name' => 'Deluxe Triple Room',
                'tagline' => 'Easy comfort for three',
                'description' => 'A Deluxe Triple Room with beds for 3 guests. Enquire for availability and rates.',
                'image' => '/storage/rooms/deluxe.jpg',
                'images' => ['/storage/rooms/deluxe.jpg'],
                'capacity' => '3 guests',
                'size' => '3 beds',
                'features' => ['AC', 'Free WiFi', 'Mountain View'],
            ],
            [
                'room_type_id' => $deluxeType->id,
                'name' => 'Deluxe Family Room',
                'tagline' => 'Space for the whole family',
                'description' => 'A Deluxe Family Room with 4 large double beds for 4 guests. Enquire for availability and rates.',
                'image' => '/storage/rooms/family.jpg',
                'images' => ['/storage/rooms/family.jpg'],
                'capacity' => '4 guests',
                'size' => '4 large double beds',
                'features' => ['AC', 'Free WiFi', 'Living Area'],
            ],
            [
                'room_type_id' => $suiteType->id,
                'name' => 'Family Suite',
                'tagline' => 'Room to gather, space to breathe',
                'description' => 'A Family Suite for up to 8 guests — the largest accommodation at Mounts Edge Regency, ideal for larger families and groups. Enquire for availability and rates.',
                'image' => '/storage/rooms/villa.jpg',
                'images' => ['/storage/rooms/villa.jpg'],
                'capacity' => '8 guests',
                'size' => 'Suite',
                'features' => ['AC', 'Free WiFi', 'Living Area', 'Mountain View'],
            ],
        ];

        foreach ($rooms as $data) {
            $features = $data['features'];
            unset($data['features']);

            $room = Room::firstOrCreate(['name' => $data['name']], $data);

            foreach ($features as $featureName) {
                $feature = Feature::firstOrCreate(['name' => $featureName]);
                $room->features()->syncWithoutDetaching([$feature->id]);
            }
        }
    }
}