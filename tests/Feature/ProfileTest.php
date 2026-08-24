<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_is_displayed(): void
    {
        $user = User::factory()->admin()->create();

        $response = $this
            ->actingAs($user)
            ->get('/profile');

        $response->assertOk();
    }

    public function test_profile_information_can_be_updated(): void
    {
        $user = User::factory()->admin()->create();

        $response = $this
            ->actingAs($user)
            ->patch('/profile', [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'current_password' => 'password',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $user->refresh();

        $this->assertSame('Test User', $user->name);
        $this->assertSame('test@example.com', $user->email);
        $this->assertNotNull($user->email_verified_at);
    }

    public function test_current_password_is_required_to_change_email(): void
    {
        $user = User::factory()->admin()->create();

        $this->actingAs($user)->from('/profile')->patch('/profile', [
            'name' => $user->name,
            'email' => 'new@example.com',
            'current_password' => 'wrong-password',
        ])->assertSessionHasErrors('current_password')->assertRedirect('/profile');

        $this->assertSame($user->email, $user->fresh()->email);
    }

    public function test_profile_uses_admin_navigation(): void
    {
        $this->actingAs(User::factory()->admin()->create())->get('/profile')
            ->assertOk()
            ->assertSee('Dashboard')
            ->assertSee('Rooms')
            ->assertSee('Weddings')
            ->assertSee('Gallery')
            ->assertSee('Enquiries')
            ->assertSee('Admin Accounts')
            ->assertSee('My Profile');
    }

    public function test_email_verification_status_is_unchanged_when_the_email_address_is_unchanged(): void
    {
        $user = User::factory()->admin()->unverified()->create();

        $response = $this
            ->actingAs($user)
            ->patch('/profile', [
                'name' => 'Test User',
                'email' => $user->email,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $this->assertNull($user->refresh()->email_verified_at);
    }

}
