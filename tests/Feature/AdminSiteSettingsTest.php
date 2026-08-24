<?php

namespace Tests\Feature;

use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminSiteSettingsTest extends TestCase
{
    use RefreshDatabase;

    private array $settings = [
        'phone_display' => '081 123 4567',
        'phone_link' => '+94811234567',
        'whatsapp_number' => '94771234567',
        'public_email' => 'hello@mountsedge.test',
        'notification_email' => 'inbox@mountsedge.test',
        'address' => 'New Hotel Address, Sri Lanka',
        'map_url' => 'https://maps.google.com/?q=hotel',
    ];

    public function test_only_admins_can_manage_site_settings(): void
    {
        $this->get('/admin/settings')->assertRedirect('/login');
        $this->actingAs(User::factory()->create())->get('/admin/settings')->assertForbidden();
        $this->actingAs(User::factory()->admin()->create())->get('/admin/settings')->assertOk();
    }

    public function test_admin_can_update_site_contact_settings(): void
    {
        $this->actingAs(User::factory()->admin()->create())
            ->put('/admin/settings', $this->settings)
            ->assertSessionHasNoErrors();

        $this->assertSame('hello@mountsedge.test', SiteSetting::current()->public_email);
        $this->assertSame('94771234567', SiteSetting::current()->whatsapp_number);
    }

    public function test_public_contact_page_uses_saved_settings(): void
    {
        SiteSetting::current()->update($this->settings);

        $this->get('/contact')
            ->assertOk()
            ->assertSee('081 123 4567')
            ->assertSee('hello@mountsedge.test')
            ->assertSee('New Hotel Address, Sri Lanka')
            ->assertSee('https://maps.google.com/?q=hotel', false);
    }
}
