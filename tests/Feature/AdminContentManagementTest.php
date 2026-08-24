<?php

namespace Tests\Feature;

use App\Models\GalleryCategory;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\User;
use App\Models\WeddingHall;
use App\Models\WeddingPackage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminContentManagementTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->admin()->create();
    }

    public function test_wedding_hall_requires_valid_fields_and_image(): void
    {
        Storage::fake('public');

        $this->actingAs($this->admin())->post('/admin/weddings/hall', [
            'name' => 'Hill Hall',
            'new_images' => [UploadedFile::fake()->create('payload.php', 10, 'application/x-php')],
        ])->assertSessionHasErrors('new_images.0');

        $this->assertDatabaseMissing('wedding_halls', ['name' => 'Hill Hall']);
    }

    public function test_admin_can_create_wedding_hall_and_empty_features_are_removed(): void
    {
        Storage::fake('public');

        $this->actingAs($this->admin())->post('/admin/weddings/hall', [
            'name' => 'Hill Hall',
            'features' => [' Mountain view ', '', '  '],
            'new_images' => [UploadedFile::fake()->createWithContent('hall.jpg', base64_decode('/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAP//////////////////////////////////////////////////////////////////////////////////////2wBDAf//////////////////////////////////////////////////////////////////////////////////////wAARCAABAAEDASIAAhEBAxEB/8QAFQABAQAAAAAAAAAAAAAAAAAAAAX/xAAUEAEAAAAAAAAAAAAAAAAAAAAA/9oADAMBAAIQAxAAAAF//8QAFBABAAAAAAAAAAAAAAAAAAAAAP/aAAgBAQABBQJ//8QAFBEBAAAAAAAAAAAAAAAAAAAAAP/aAAgBAwEBPwF//8QAFBEBAAAAAAAAAAAAAAAAAAAAAP/aAAgBAgEBPwF//8QAFBABAAAAAAAAAAAAAAAAAAAAAP/aAAgBAQAGPwJ//8QAFBABAAAAAAAAAAAAAAAAAAAAAP/aAAgBAQABPyF//9oADAMBAAIAAwAAABD/xAAUEQEAAAAAAAAAAAAAAAAAAAAA/9oACAEDAQE/EF//xAAUEQEAAAAAAAAAAAAAAAAAAAAA/9oACAECAQE/EF//xAAUEAEAAAAAAAAAAAAAAAAAAAAA/9oACAEBAAE/EF//2Q=='))],
        ])->assertSessionHasNoErrors();

        $this->assertSame(['Mountain view'], WeddingHall::firstOrFail()->features);
    }

    public function test_wedding_package_ignores_unapproved_columns(): void
    {
        $this->actingAs($this->admin())->post('/admin/weddings/packages', [
            'name' => 'Classic',
            'guests' => '100 guests',
            'includes' => [['title' => ' Starters ', 'rule' => '', 'items' => [' Soup ', '']]],
            'created_at' => '2000-01-01 00:00:00',
        ])->assertSessionHasNoErrors();

        $package = WeddingPackage::firstOrFail();
        $this->assertSame(
            [['title' => 'Starters', 'rule' => '', 'items' => ['Soup']]],
            $package->includes
        );
        $this->assertNotSame('2000-01-01 00:00:00', $package->created_at->format('Y-m-d H:i:s'));
    }

    public function test_room_requires_an_existing_room_type_and_safe_image(): void
    {
        Storage::fake('public');
        $admin = $this->admin();

        $this->actingAs($admin)->post('/admin/rooms', [
            'room_type_id' => 999,
            'name' => 'Room',
            'tagline' => 'Tagline',
            'description' => 'Description',
            'capacity' => '2 guests',
            'size' => '30 sqm',
            'new_images' => [UploadedFile::fake()->createWithContent('room.jpg', base64_decode('/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAP//////////////////////////////////////////////////////////////////////////////////////2wBDAf//////////////////////////////////////////////////////////////////////////////////////wAARCAABAAEDASIAAhEBAxEB/8QAFQABAQAAAAAAAAAAAAAAAAAAAAX/xAAUEAEAAAAAAAAAAAAAAAAAAAAA/9oADAMBAAIQAxAAAAF//8QAFBABAAAAAAAAAAAAAAAAAAAAAP/aAAgBAQABBQJ//8QAFBEBAAAAAAAAAAAAAAAAAAAAAP/aAAgBAwEBPwF//8QAFBEBAAAAAAAAAAAAAAAAAAAAAP/aAAgBAgEBPwF//8QAFBABAAAAAAAAAAAAAAAAAAAAAP/aAAgBAQAGPwJ//8QAFBABAAAAAAAAAAAAAAAAAAAAAP/aAAgBAQABPyF//9oADAMBAAIAAwAAABD/xAAUEQEAAAAAAAAAAAAAAAAAAAAA/9oACAEDAQE/EF//xAAUEQEAAAAAAAAAAAAAAAAAAAAA/9oACAECAQE/EF//xAAUEAEAAAAAAAAAAAAAAAAAAAAA/9oACAEBAAE/EF//2Q=='))],
        ])->assertSessionHasErrors('room_type_id');

        $type = RoomType::create(['name' => 'Suite', 'slug' => 'suite', 'icon' => '<svg></svg>']);
        $this->post('/admin/rooms', [
            'room_type_id' => $type->id,
            'name' => 'Room',
            'tagline' => 'Tagline',
            'description' => 'Description',
            'capacity' => '2 guests',
            'size' => '30 sqm',
            'new_images' => [UploadedFile::fake()->create('payload.php', 10, 'application/x-php')],
        ])->assertSessionHasErrors('new_images.0');
    }

    public function test_admin_can_update_an_existing_room(): void
    {
        Storage::fake('public');
        $type = RoomType::create(['name' => 'Suite', 'slug' => 'suite', 'icon' => '<svg></svg>']);
        $room = Room::create([
            'room_type_id' => $type->id,
            'name' => 'Original Room',
            'tagline' => 'Tagline',
            'description' => 'Description',
            'capacity' => '2 guests',
            'size' => '30 sqm',
            'image' => '/storage/rooms/original.jpg',
            'images' => ['/storage/rooms/original.jpg'],
        ]);

        $this->actingAs($this->admin())->put("/admin/rooms/{$room->id}", [
            'room_type_id' => $type->id,
            'name' => 'Updated Room',
            'tagline' => 'Updated Tagline',
            'description' => 'Updated Description',
            'capacity' => '4 guests',
            'size' => '45 sqm',
            'existing_images' => ['/storage/rooms/original.jpg'],
        ])->assertSessionHasNoErrors()->assertRedirect(route('admin.rooms.index'));

        $this->assertSame('Updated Room', $room->fresh()->name);
    }

    public function test_admin_can_update_an_existing_wedding_package(): void
    {
        $package = WeddingPackage::create([
            'name' => 'Classic',
            'guests' => '100 guests',
            'is_popular' => false,
            'includes' => [['title' => 'Starters', 'rule' => '', 'items' => ['Soup']]],
        ]);

        $this->actingAs($this->admin())->put("/admin/weddings/packages/{$package->id}", [
            'name' => 'Classic Updated',
            'guests' => '150 guests',
            'includes' => [['title' => ' Mains ', 'rule' => 'Choice of 1', 'items' => [' Steak ', '', ' Fish ']]],
        ])->assertSessionHasNoErrors();

        $this->assertSame(
            [['title' => 'Mains', 'rule' => 'Choice of 1', 'items' => ['Steak', 'Fish']]],
            $package->fresh()->includes
        );
    }

    private function fakeImage(string $name): UploadedFile
    {
        return UploadedFile::fake()->createWithContent($name, base64_decode('/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAP//////////////////////////////////////////////////////////////////////////////////////2wBDAf//////////////////////////////////////////////////////////////////////////////////////wAARCAABAAEDASIAAhEBAxEB/8QAFQABAQAAAAAAAAAAAAAAAAAAAAX/xAAUEAEAAAAAAAAAAAAAAAAAAAAA/9oADAMBAAIQAxAAAAF//8QAFBABAAAAAAAAAAAAAAAAAAAAAP/aAAgBAQABBQJ//8QAFBEBAAAAAAAAAAAAAAAAAAAAAP/aAAgBAwEBPwF//8QAFBEBAAAAAAAAAAAAAAAAAAAAAP/aAAgBAgEBPwF//8QAFBABAAAAAAAAAAAAAAAAAAAAAP/aAAgBAQAGPwJ//8QAFBABAAAAAAAAAAAAAAAAAAAAAP/aAAgBAQABPyF//9oADAMBAAIAAwAAABD/xAAUEQEAAAAAAAAAAAAAAAAAAAAA/9oACAEDAQE/EF//xAAUEQEAAAAAAAAAAAAAAAAAAAAA/9oACAECAQE/EF//xAAUEAEAAAAAAAAAAAAAAAAAAAAA/9oACAEBAAE/EF//2Q=='));
    }

    private function roomPayload(RoomType $type, array $extra = []): array
    {
        return array_merge([
            'room_type_id' => $type->id,
            'name' => 'Room',
            'tagline' => 'Tagline',
            'description' => 'Description',
            'capacity' => '2 guests',
            'size' => '30 sqm',
        ], $extra);
    }

    public function test_room_stores_multiple_images_in_order_with_first_as_cover(): void
    {
        Storage::fake('public');
        $type = RoomType::create(['name' => 'Suite', 'slug' => 'suite', 'icon' => '<svg></svg>']);

        $this->actingAs($this->admin())->post('/admin/rooms', $this->roomPayload($type, [
            'new_images' => [$this->fakeImage('one.jpg'), $this->fakeImage('two.jpg'), $this->fakeImage('three.jpg')],
        ]))->assertSessionHasNoErrors();

        $room = Room::firstOrFail();
        $this->assertCount(3, $room->images);
        $this->assertSame($room->images[0], $room->image);
        $this->assertCount(3, Storage::disk('public')->files('rooms'));
    }

    public function test_room_rejects_more_than_five_images_without_storing_files(): void
    {
        Storage::fake('public');
        $type = RoomType::create(['name' => 'Suite', 'slug' => 'suite', 'icon' => '<svg></svg>']);

        $this->actingAs($this->admin())->post('/admin/rooms', $this->roomPayload($type, [
            'new_images' => array_map(fn ($i) => $this->fakeImage("img{$i}.jpg"), range(1, 6)),
        ]))->assertSessionHasErrors('new_images');

        $this->assertSame(0, Room::count());
        $this->assertEmpty(Storage::disk('public')->files('rooms'));
    }

    public function test_room_update_reorders_kept_images_and_deletes_dropped_files(): void
    {
        Storage::fake('public');
        $type = RoomType::create(['name' => 'Suite', 'slug' => 'suite', 'icon' => '<svg></svg>']);

        $this->actingAs($this->admin())->post('/admin/rooms', $this->roomPayload($type, [
            'new_images' => [$this->fakeImage('one.jpg'), $this->fakeImage('two.jpg'), $this->fakeImage('three.jpg')],
        ]))->assertSessionHasNoErrors();

        $room = Room::firstOrFail();
        [$first, $second, $third] = $room->images;

        // Keep the last two, in reversed order, and drop the first.
        $this->put("/admin/rooms/{$room->id}", $this->roomPayload($type, [
            'name' => 'Updated Room',
            'existing_images' => [$third, $second],
        ]))->assertSessionHasNoErrors();

        $room->refresh();
        $this->assertSame([$third, $second], $room->images);
        $this->assertSame($third, $room->image);
        Storage::disk('public')->assertMissing(str_replace('/storage/', '', $first));
        Storage::disk('public')->assertExists(str_replace('/storage/', '', $second));
    }

    public function test_room_update_ignores_existing_images_the_room_does_not_own(): void
    {
        Storage::fake('public');
        $type = RoomType::create(['name' => 'Suite', 'slug' => 'suite', 'icon' => '<svg></svg>']);

        $this->actingAs($this->admin())->post('/admin/rooms', $this->roomPayload($type, [
            'new_images' => [$this->fakeImage('one.jpg')],
        ]))->assertSessionHasNoErrors();

        $room = Room::firstOrFail();
        $owned = $room->images[0];

        $this->put("/admin/rooms/{$room->id}", $this->roomPayload($type, [
            'existing_images' => [$owned, '/storage/rooms/../../../etc/passwd'],
        ]))->assertSessionHasNoErrors();

        $this->assertSame([$owned], $room->fresh()->images);
    }

    public function test_wedding_hall_stores_multiple_images_in_order(): void
    {
        Storage::fake('public');

        $this->actingAs($this->admin())->post('/admin/weddings/hall', [
            'name' => 'Hill Hall',
            'new_images' => [$this->fakeImage('a.jpg'), $this->fakeImage('b.jpg')],
        ])->assertSessionHasNoErrors();

        $hall = WeddingHall::firstOrFail();
        $this->assertCount(2, $hall->images);
        $this->assertSame($hall->images[0], $hall->image);
    }

    public function test_admin_forms_expose_the_multi_image_controls(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->get('/admin/rooms')
            ->assertOk()
            ->assertSee('name="existing_images[]"', false)
            ->assertSee('name="new_images[]"', false)
            ->assertSee('roomAdmin()', false);

        $this->actingAs($admin)->get('/admin/weddings')
            ->assertOk()
            ->assertSee('name="existing_images[]"', false)
            ->assertSee('name="new_images[]"', false)
            ->assertSee('hallAdmin()', false);
    }

    public function test_gallery_rejects_non_image_uploads(): void
    {
        Storage::fake('public');
        $category = GalleryCategory::create(['name' => 'Hotel']);

        $this->actingAs($this->admin())->post('/admin/gallery/items', [
            'gallery_category_id' => $category->id,
            'image' => UploadedFile::fake()->create('payload.php', 10, 'application/x-php'),
        ])->assertSessionHasErrors('image');
    }
}
