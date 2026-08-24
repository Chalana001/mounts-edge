<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminUserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_manage_admin_accounts(): void
    {
        $this->get('/admin/users')->assertRedirect('/login');
    }

    public function test_non_admin_users_cannot_manage_admin_accounts(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/admin/users')
            ->assertForbidden();
    }

    public function test_admin_can_create_an_account(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->post('/admin/users', [
            'name' => 'Second Admin',
            'email' => 'second@example.com',
            'password' => 'secure-password',
            'password_confirmation' => 'secure-password',
            'current_password' => 'password',
        ])->assertSessionHasNoErrors();

        $user = User::where('email', 'second@example.com')->firstOrFail();
        $this->assertTrue($user->is_admin);
        $this->assertTrue(Hash::check('secure-password', $user->password));
    }

    public function test_admin_can_change_an_account_password(): void
    {
        $admin = User::factory()->admin()->create();
        $otherAdmin = User::factory()->admin()->create();

        $this->actingAs($admin)->put("/admin/users/{$otherAdmin->id}/password", [
            'password' => 'new-secure-password',
            'password_confirmation' => 'new-secure-password',
            'current_password' => 'password',
        ])->assertSessionHasNoErrors();

        $this->assertTrue(Hash::check('new-secure-password', $otherAdmin->fresh()->password));
    }

    public function test_admin_can_delete_another_account_but_not_their_own(): void
    {
        $admin = User::factory()->admin()->create();
        $otherAdmin = User::factory()->admin()->create();

        $this->actingAs($admin)->delete("/admin/users/{$otherAdmin->id}", ['current_password' => 'password'])->assertSessionHasNoErrors();
        $this->assertModelMissing($otherAdmin);

        $this->actingAs($admin)->delete("/admin/users/{$admin->id}", ['current_password' => 'password'])->assertSessionHasErrors('user');
        $this->assertModelExists($admin);
    }

    public function test_admin_can_delete_their_own_account_when_another_admin_remains(): void
    {
        $admin = User::factory()->admin()->create();
        $otherAdmin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->delete("/admin/users/{$admin->id}", ['current_password' => 'password'])
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('login'));

        $this->assertModelMissing($admin);
        $this->assertModelExists($otherAdmin);
        $this->assertGuest();
    }
}
