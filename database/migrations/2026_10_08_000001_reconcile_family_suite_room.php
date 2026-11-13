<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Owner-confirmed 2026-10-08: "Deluxe Family Room" and "Family Suite"
     * are one accommodation. Canonical public name: Family Suite, 8 guests,
     * 538 ft², 4 large double beds. Production databases seeded before this
     * clarification hold both rows; reconcile them without dropping the
     * feature/image associations an admin may have edited.
     */
    public function up(): void
    {
        if (! Schema::hasTable('rooms')) {
            return;
        }

        $family = DB::table('rooms')->where('name', 'Deluxe Family Room')->first();
        $suite = DB::table('rooms')->where('name', 'Family Suite')->first();

        $suiteTypeId = DB::table('room_types')->where('slug', 'family-suite')->value('id');

        if ($family && $suite) {
            // The owner-confirmed details become the canonical row content.
            DB::table('rooms')->where('id', $suite->id)->update([
                'room_type_id' => $suiteTypeId ?: $suite->room_type_id,
                'tagline' => 'Room to gather, space to breathe',
                'description' => 'A Family Suite of 538 ft² for up to 8 guests with 4 large double beds, a balcony with a view, air conditioning, and a private bathroom. Enquire for availability and rates.',
                'image' => $family->image ?: $suite->image,
                'images' => $family->images ?: $suite->images,
                'capacity' => '8 guests',
                'size' => '538 ft² · 4 large double beds',
                'updated_at' => now(),
            ]);

            // Carry over any admin-added feature links from the family row.
            if (Schema::hasTable('feature_room')) {
                DB::table('feature_room')
                    ->where('room_id', $family->id)
                    ->whereNotIn('room_id', [$suite->id])
                    ->get()
                    ->each(function ($link) use ($suite) {
                        DB::table('feature_room')->updateOrInsert(
                            ['room_id' => $suite->id, 'feature_id' => $link->feature_id],
                            ['room_id' => $suite->id, 'feature_id' => $link->feature_id]
                        );
                    });
            }

            // Enquiries reference room details as free-form JSON, so deleting
            // the duplicate row cannot break them.
            DB::table('rooms')->where('id', $family->id)->delete();
        } elseif ($family) {
            DB::table('rooms')->where('id', $family->id)->update([
                'room_type_id' => $suiteTypeId ?: $family->room_type_id,
                'name' => 'Family Suite',
                'tagline' => 'Room to gather, space to breathe',
                'description' => 'A Family Suite of 538 ft² for up to 8 guests with 4 large double beds, a balcony with a view, air conditioning, and a private bathroom. Enquire for availability and rates.',
                'capacity' => '8 guests',
                'size' => '538 ft² · 4 large double beds',
                'updated_at' => now(),
            ]);
        } elseif ($suite) {
            DB::table('rooms')->where('id', $suite->id)->update([
                'room_type_id' => $suiteTypeId ?: $suite->room_type_id,
                'tagline' => 'Room to gather, space to breathe',
                'description' => 'A Family Suite of 538 ft² for up to 8 guests with 4 large double beds, a balcony with a view, air conditioning, and a private bathroom. Enquire for availability and rates.',
                'image' => $suite->image ?: '/storage/rooms/family.jpg',
                'images' => $suite->images ?: json_encode(['/storage/rooms/family.jpg']),
                'capacity' => '8 guests',
                'size' => '538 ft² · 4 large double beds',
                'updated_at' => now(),
            ]);
        }

        if ($suiteTypeId) {
            // Family Suite belongs to the Family Suites tab.
            DB::table('rooms')->where('name', 'Family Suite')->update(['room_type_id' => $suiteTypeId]);
        }
    }

    public function down(): void
    {
        // The pre-clarification two-room state was factually wrong; rolling
        // back would knowingly reintroduce a duplicate accommodation, so the
        // migration is intentionally one-way.
    }
};
