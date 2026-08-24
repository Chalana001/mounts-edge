<?php

namespace Tests\Feature;

use App\Models\Enquiry;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminEnquiryManagementTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->admin()->create();
    }

    private function enquiry(array $attributes = []): Enquiry
    {
        return Enquiry::factory()->create($attributes);
    }

    public function test_admin_can_view_inbox_and_detail_but_non_admin_cannot(): void
    {
        $enquiry = $this->enquiry();

        $this->actingAs(User::factory()->create())->get('/admin/enquiries')->assertForbidden();

        $this->actingAs($this->admin())->get('/admin/enquiries')
            ->assertOk()
            ->assertSee('Jane Guest');

        $this->get("/admin/enquiries/{$enquiry->id}")
            ->assertOk()
            ->assertSee('jane@example.com')
            ->assertSee('wa.me/94771234567', false);
    }

    public function test_admin_can_manually_change_status(): void
    {
        $enquiry = $this->enquiry();

        $this->actingAs($this->admin())
            ->patch("/admin/enquiries/{$enquiry->id}/status", ['status' => Enquiry::STATUS_CONTACTED])
            ->assertSessionHasNoErrors();

        $this->assertSame(Enquiry::STATUS_CONTACTED, $enquiry->fresh()->status);
    }

    public function test_admin_can_trash_restore_and_permanently_delete_an_enquiry(): void
    {
        $enquiry = $this->enquiry();
        $admin = $this->admin();

        $this->actingAs($admin)->delete("/admin/enquiries/{$enquiry->id}");
        $this->assertSoftDeleted($enquiry);

        $this->post("/admin/enquiries/{$enquiry->id}/restore");
        $this->assertNotSoftDeleted($enquiry);

        $enquiry->delete();
        $this->delete("/admin/enquiries/{$enquiry->id}/force");
        $this->assertDatabaseMissing('enquiries', ['id' => $enquiry->id]);
    }

    public function test_enquiry_details_are_shown_in_the_inbox_and_detail_page(): void
    {
        $enquiry = $this->enquiry([
            'type' => Enquiry::TYPE_ROOM,
            'details' => [
                'room_type' => 'Deluxe Rooms',
                'check_in' => '2026-06-12',
                'check_out' => '2026-06-14',
                'guests' => 3,
            ],
        ]);

        $this->actingAs($this->admin())->get("/admin/enquiries/{$enquiry->id}")
            ->assertOk()
            ->assertSee('Enquiry Details')
            ->assertSee('Room type')
            ->assertSee('Deluxe Rooms')
            ->assertSee('Check-in')
            ->assertSee('12 Jun 2026');

        $this->get('/admin/enquiries')
            ->assertOk()
            ->assertSee('3 guests');
    }

    public function test_detail_block_is_hidden_for_a_general_enquiry(): void
    {
        $enquiry = $this->enquiry(['type' => Enquiry::TYPE_GENERAL, 'details' => []]);

        $this->actingAs($this->admin())->get("/admin/enquiries/{$enquiry->id}")
            ->assertOk()
            ->assertDontSee('Enquiry Details');
    }

    public function test_empty_trash_requires_current_admin_password(): void
    {
        $enquiry = $this->enquiry();
        $enquiry->delete();
        $admin = $this->admin();

        $this->actingAs($admin)->delete('/admin/enquiries/trash', ['password' => 'wrong-password'])
            ->assertSessionHasErrors('password');
        $this->assertDatabaseHas('enquiries', ['id' => $enquiry->id]);

        $this->delete('/admin/enquiries/trash', ['password' => 'password'])
            ->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('enquiries', ['id' => $enquiry->id]);
    }
}
