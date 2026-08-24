<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('wedding_halls', function (Blueprint $table) {
            $table->json('images')->nullable()->after('image');
        });

        DB::table('wedding_halls')->select('id', 'image')->orderBy('id')->chunk(100, function ($halls) {
            foreach ($halls as $hall) {
                DB::table('wedding_halls')->where('id', $hall->id)->update([
                    'images' => json_encode($hall->image ? [$hall->image] : []),
                ]);
            }
        });
    }

    public function down(): void
    {
        Schema::table('wedding_halls', function (Blueprint $table) {
            $table->dropColumn('images');
        });
    }
};
