<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@mountsedgeregency.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin@mer123'),
                'email_verified_at' => now(),
                'is_admin' => true,
            ]
        );
        $this->call([
        RoomSeeder::class,
        WeddingSeeder::class,
        GallerySeeder::class,
    ]);
    }
}
