<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->json('images')->nullable()->after('image');
        });

        // Backfill in PHP so this works on both sqlite and mysql. The existing
        // single image becomes the first (cover) entry of the new list.
        DB::table('rooms')->select('id', 'image')->orderBy('id')->chunk(100, function ($rooms) {
            foreach ($rooms as $room) {
                DB::table('rooms')->where('id', $room->id)->update([
                    'images' => json_encode($room->image ? [$room->image] : []),
                ]);
            }
        });
    }

    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropColumn('images');
        });
    }
};
