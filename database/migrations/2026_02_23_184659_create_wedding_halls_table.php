<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('wedding_halls', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('tagline')->nullable();
            $table->text('description')->nullable();
            $table->string('capacity')->nullable();
            $table->string('area')->nullable();
            $table->string('style')->nullable();
            $table->string('image')->nullable();
            $table->json('features')->nullable(); // Tags/Features ටික Array එකක් විදියට සේව් වෙන්න
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wedding_halls');
    }
};
