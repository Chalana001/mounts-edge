<?php

namespace Tests\Feature;

use App\Models\Feature;
use App\Models\Room;
use App\Models\RoomType;
use Database\Seeders\RoomSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class FamilySuiteReconciliationTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeder_repairs_an_existing_duplicate_family_accommodation(): void
    {
        $deluxe = RoomType::firstOrCreate(
            ['slug' => 'deluxe'],
            ['name' => 'Deluxe Rooms', 'icon' => 'home']
        );
        $suite = RoomType::firstOrCreate(
            ['slug' => 'family-suite'],
            ['name' => 'Family Suites', 'icon' => 'home']
        );

        // Simulate a database seeded before the 2026-10-08 clarification.
        Room::create([
            'room_type_id' => $deluxe->id,
            'name' => 'Deluxe Family Room',
            'tagline' => 'Space for the whole family',
            'description' => 'Old duplicate copy.',
            'image' => '/storage/rooms/family.jpg',
            'images' => ['/storage/rooms/family.jpg'],
            'capacity' => '4 guests',
            'size' => '50 m² · 4 large double beds',
        ]);
        $suiteRoom = Room::create([
            'room_type_id' => $suite->id,
            'name' => 'Family Suite',
            'tagline' => 'Old tagline',
            'description' => 'Old suite copy.',
            'image' => '/storage/rooms/villa.jpg',
            'images' => ['/storage/rooms/villa.jpg'],
            'capacity' => '8 guests',
            'size' => 'Suite',
        ]);
        $legacyFeature = Feature::firstOrCreate(['name' => 'Legacy Feature']);
        $suiteRoom->features()->attach($legacyFeature->id);

        Artisan::call('db:seed', ['--class' => RoomSeeder::class]);

        $this->assertSame(4, Room::count());
        $this->assertFalse(Room::where('name', 'Deluxe Family Room')->exists());

        $canonical = Room::where('name', 'Family Suite')->firstOrFail();
        $this->assertSame('8 guests', $canonical->capacity);
        $this->assertSame('538 ft² · 4 large double beds', $canonical->size);
        $this->assertSame('Family Suites', $canonical->roomType->name);
        $this->assertSame('/storage/rooms/family.jpg', $canonical->image);
        $this->assertTrue($canonical->features->contains('name', 'Legacy Feature'));
    }
}
