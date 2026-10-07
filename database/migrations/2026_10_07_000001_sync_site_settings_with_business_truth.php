<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * The id=1 row was inserted by the create-table migration with dev
     * placeholders, and firstOrCreate() never updates an existing row — so
     * the verified constants in SiteSetting::DEFAULTS were being overridden
     * by stale values in every environment that already had the table.
     */
    public function up(): void
    {
        if (! DB::getSchemaBuilder()->hasTable('site_settings')) {
            return;
        }

        // Owner-verified 2026-10-01/02, docs/BUSINESS-TRUTH.md §1.
        DB::table('site_settings')->where('id', 1)->update([
            'phone_display' => '055 225 6500',
            'phone_link' => '+94552256500',
            'whatsapp_number' => '94777403940',
            'public_email' => 'mountedgeregency@gmail.com',
            'notification_email' => 'mountedgeregency@gmail.com',
            'address' => 'Kandy Rd, Gurulupotha, Hasalaka 20960, Mahiyangana, Sri Lanka',
            'map_url' => 'https://maps.google.com',
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        if (! DB::getSchemaBuilder()->hasTable('site_settings')) {
            return;
        }

        // Dev placeholders the row held before the sync — reverting restores
        // the pre-fix state, not a state anyone should deploy.
        DB::table('site_settings')->where('id', 1)->update([
            'phone_display' => '055 2 256 500',
            'phone_link' => '+94552256500',
            'whatsapp_number' => '94704589764',
            'public_email' => 'ckalhara7277@gmail.com',
            'notification_email' => 'info@mountsedgeregency.com',
            'address' => 'Gurulupotha, Hasalaka, Mahiyangana, Sri Lanka',
            'map_url' => 'https://maps.google.com',
            'updated_at' => now(),
        ]);
    }
};
