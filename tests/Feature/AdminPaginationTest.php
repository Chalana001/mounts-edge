<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class AdminPaginationTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->admin()->create();
    }

    public function test_admin_rooms_are_paginated_without_changing_supporting_collections(): void
    {
        $this->actingAs($this->admin())->get('/admin/rooms')
            ->assertOk()
            ->assertViewHas('rooms', fn ($rooms) => $rooms instanceof LengthAwarePaginator
                && $rooms->perPage() === 12
                && $rooms->getPageName() === 'rooms_page')
            ->assertViewHas('roomTypes', fn ($roomTypes) => $roomTypes instanceof \Illuminate\Database\Eloquent\Collection);
    }

    public function test_admin_gallery_items_are_paginated_but_categories_are_complete(): void
    {
        $this->actingAs($this->admin())->get('/admin/gallery')
            ->assertOk()
            ->assertViewHas('items', fn ($items) => $items instanceof LengthAwarePaginator
                && $items->perPage() === 20
                && $items->getPageName() === 'gallery_page')
            ->assertViewHas('categories', fn ($categories) => $categories instanceof \Illuminate\Database\Eloquent\Collection);
    }

    public function test_admin_wedding_lists_use_independent_paginators(): void
    {
        $this->actingAs($this->admin())->get('/admin/weddings')
            ->assertOk()
            ->assertViewHas('halls', fn ($halls) => $halls instanceof LengthAwarePaginator
                && $halls->getPageName() === 'halls_page')
            ->assertViewHas('packages', fn ($packages) => $packages instanceof LengthAwarePaginator
                && $packages->getPageName() === 'packages_page');
    }

    public function test_admin_users_are_paginated(): void
    {
        $this->actingAs($this->admin())->get('/admin/users')
            ->assertOk()
            ->assertViewHas('users', fn ($users) => $users instanceof LengthAwarePaginator
                && $users->perPage() === 15
                && $users->getPageName() === 'users_page');
    }

    public function test_public_room_gallery_and_wedding_pages_remain_unpaginated(): void
    {
        $this->get('/luxury-stay')->assertViewHas('roomTypes', fn ($items) => ! $items instanceof LengthAwarePaginator);
        $this->get('/gallery')->assertViewHas('galleryItems', fn ($items) => ! $items instanceof LengthAwarePaginator);
        $this->get('/weddings')->assertOk();
    }
}
