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
        Schema::create('wedding_packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('guests')->nullable();
            $table->boolean('is_popular')->default(false); // Most Popular ද කියලා බලන්න
            $table->json('includes')->nullable(); // Package එකේ තියෙන දේවල්
            $table->timestamps();
        });
    }   

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wedding_packages');
    }
};
