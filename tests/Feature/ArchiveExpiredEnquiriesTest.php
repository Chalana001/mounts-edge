<?php

namespace Tests\Feature;

use App\Models\Enquiry;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArchiveExpiredEnquiriesTest extends TestCase
{
    use RefreshDatabase;

    private function enquiry(array $attributes = []): Enquiry
    {
        return Enquiry::factory()->create($attributes);
    }

    public function test_command_soft_deletes_only_enquiries_older_than_twelve_months(): void
    {
        $expired = $this->enquiry();
        $expired->timestamps = false;
        $expired->forceFill(['created_at' => now()->subMonths(12)->subDay()])->save();
        $current = $this->enquiry();
        $current->timestamps = false;
        $current->forceFill(['created_at' => now()->subMonths(12)->addDay()])->save();
        $alreadyTrashed = $this->enquiry();
        $alreadyTrashed->timestamps = false;
        $alreadyTrashed->forceFill(['created_at' => now()->subYears(2)])->save();
        $alreadyTrashed->delete();

        $this->artisan('enquiries:archive-expired')->assertSuccessful();

        $this->assertSoftDeleted($expired);
        $this->assertNotSoftDeleted($current);
        $this->assertDatabaseHas('enquiries', ['id' => $alreadyTrashed->id]);
    }

    public function test_cleanup_is_scheduled_weekly_on_sunday_at_midnight(): void
    {
        $events = app(Schedule::class)->events();
        $event = collect($events)->first(fn ($event) => str_contains($event->command ?? '', 'enquiries:archive-expired'));

        $this->assertNotNull($event);
        $this->assertSame('0 0 * * 0', $event->expression);
    }
}
