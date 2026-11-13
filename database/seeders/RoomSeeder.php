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
        // Owner-confirmed 2026-10-08: four accommodations — three Deluxe
        // rooms plus one Family Suite. The OTA's "Deluxe Family Room" and
        // the previous seeded "Family Suite" are the same accommodation;
        // Family Suite is the canonical public name. Rates exist in four
        // tiers per room (docs/BUSINESS-TRUTH.md §3) but are deliberately
        // NOT seeded: the site is enquiry-only and prices stay on the OTA.
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
                'description' => 'A Deluxe Single Room of 25 m² with 1 large double bed, a balcony with a view, air conditioning, and a flat-screen TV. Enquire for availability and rates.',
                'image' => '/storage/rooms/deluxe.jpg',
                'images' => ['/storage/rooms/deluxe.jpg'],
                'capacity' => '1 guest',
                'size' => '25 m² · 1 large double bed',
                'features' => ['AC', 'Free WiFi', 'Mountain View', 'Private Balcony', 'Flat-screen TV'],
            ],
            [
                'room_type_id' => $deluxeType->id,
                'name' => 'Deluxe Double Room',
                'tagline' => 'Comfort meets elegance',
                'description' => 'A Deluxe Double Room of 25 m² with 2 large double beds, a balcony with a view, air conditioning, and a flat-screen TV. Enquire for availability and rates.',
                'image' => '/storage/rooms/deluxe.jpg',
                'images' => ['/storage/rooms/deluxe.jpg'],
                'capacity' => '2 guests',
                'size' => '25 m² · 2 large double beds',
                'features' => ['Mountain View', 'AC', 'Free WiFi', 'Private Balcony', 'Flat-screen TV'],
            ],
            [
                'room_type_id' => $deluxeType->id,
                'name' => 'Deluxe Triple Room',
                'tagline' => 'Easy comfort for three',
                'description' => 'A Deluxe Triple Room of 25 m² with 2 large double beds, air conditioning, and a flat-screen TV. Enquire for availability and rates.',
                'image' => '/storage/rooms/deluxe.jpg',
                'images' => ['/storage/rooms/deluxe.jpg'],
                'capacity' => '3 guests',
                'size' => '25 m² · 2 large double beds',
                'features' => ['AC', 'Free WiFi', 'Mountain View', 'Flat-screen TV'],
            ],
            [
                'room_type_id' => $suiteType->id,
                'name' => 'Family Suite',
                'tagline' => 'Room to gather, space to breathe',
                'description' => 'A Family Suite of 538 ft² for up to 8 guests with 4 large double beds, a balcony with a view, air conditioning, and a private bathroom. Enquire for availability and rates.',
                'image' => '/storage/rooms/family.jpg',
                'images' => ['/storage/rooms/family.jpg'],
                'capacity' => '8 guests',
                'size' => '538 ft² · 4 large double beds',
                'features' => ['AC', 'Free WiFi', 'Living Area', 'Private Balcony', 'Private Bathroom'],
            ],
        ];

        foreach ($rooms as $data) {
            $features = $data['features'];
            unset($data['features']);

            // updateOrCreate (not firstOrCreate) so an existing row picks up
            // corrected owner-verified details without a fresh database.
            $room = Room::updateOrCreate(['name' => $data['name']], $data);

            foreach ($features as $featureName) {
                $feature = Feature::firstOrCreate(['name' => $featureName]);
                $room->features()->syncWithoutDetaching([$feature->id]);
            }
        }

        // Remove the superseded duplicate family record on already-seeded
        // databases; keepRoomList clean via the 2026-10-08 reconciliation
        // migration on production data.
        Room::where('name', 'Deluxe Family Room')->delete();
    }
}