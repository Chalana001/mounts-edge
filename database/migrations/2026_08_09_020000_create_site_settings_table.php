<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('phone_display');
            $table->string('phone_link');
            $table->string('whatsapp_number');
            $table->string('public_email');
            $table->string('notification_email');
            $table->string('address');
            $table->text('map_url');
            $table->timestamps();
        });

        DB::table('site_settings')->insert([
            'phone_display' => '055 2 256 500',
            'phone_link' => '+94552256500',
            'whatsapp_number' => '94704589764',
            'public_email' => 'ckalhara7277@gmail.com',
            'notification_email' => 'info@mountsedgeregency.com',
            'address' => 'Gurulupotha, Hasalaka, Mahiyangana, Sri Lanka',
            'map_url' => 'https://maps.google.com',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
