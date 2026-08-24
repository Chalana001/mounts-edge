<?php

namespace Tests\Feature;

use App\Mail\NewEnquiryNotification;
use App\Models\Enquiry;
use App\Models\RoomType;
use App\Models\WeddingHall;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use RuntimeException;
use Tests\TestCase;

class EnquirySubmissionTest extends TestCase
{
    use RefreshDatabase;

    private array $payload = [
        'name' => 'Jane Guest',
        'email' => 'jane@example.com',
        'phone' => '+94771234567',
        'type' => 'Room Booking',
        'message' => 'I would like to stay for two nights.',
    ];

    /** A valid Room Booking payload with the now-required detail fields. */
    private function roomPayload(array $details = [], array $overrides = []): array
    {
        return array_merge($this->payload, [
            'type' => Enquiry::TYPE_ROOM,
            'details' => array_merge([
                'check_in' => now()->addDays(3)->format('Y-m-d'),
                'check_out' => now()->addDays(5)->format('Y-m-d'),
                'guests' => 2,
            ], $details),
        ], $overrides);
    }

    public function test_valid_enquiry_is_saved_before_email_notification(): void
    {
        Mail::fake();

        $this->from('/contact')->post('/send-enquiry', $this->roomPayload())
            ->assertRedirect('/contact')
            ->assertSessionHas('success');

        $this->assertDatabaseHas('enquiries', [
            'email' => 'jane@example.com',
            'status' => Enquiry::STATUS_NEW,
            'email_notification_failed' => false,
        ]);

        Mail::assertQueued(NewEnquiryNotification::class);
    }

    public function test_email_failure_does_not_lose_the_enquiry(): void
    {
        Mail::fake();

        $this->from('/contact')->post('/send-enquiry', $this->roomPayload())
            ->assertRedirect('/contact')
            ->assertSessionHas('success');

        $enquiry = Enquiry::where('email', 'jane@example.com')->firstOrFail();
        $this->assertFalse($enquiry->email_notification_failed);

        // Simulate the queued mail ultimately failing (e.g. an SMTP outage).
        // Laravel calls the mailable's failed() hook in that case, whether
        // the failure happens inline (sync queue) or later in a worker.
        (new NewEnquiryNotification($enquiry))->failed(new RuntimeException('Mail unavailable'));

        $this->assertTrue($enquiry->fresh()->email_notification_failed);
    }

    public function test_enquiry_submission_is_rate_limited(): void
    {
        Mail::fake();

        foreach (range(1, 5) as $attempt) {
            $this->post('/send-enquiry', $this->roomPayload())
                ->assertSessionHasNoErrors()
                ->assertRedirect();
        }

        $this->post('/send-enquiry', $this->roomPayload())->assertTooManyRequests();
    }

    public function test_room_enquiry_stores_its_details(): void
    {
        Mail::fake();
        RoomType::create(['name' => 'Deluxe Rooms', 'slug' => 'deluxe', 'icon' => '<svg></svg>']);

        $this->post('/send-enquiry', $this->roomPayload([
            'room_type' => 'Deluxe Rooms',
            'rooms' => 2,
        ]))->assertSessionHasNoErrors();

        $details = Enquiry::firstOrFail()->details;
        $this->assertSame('Deluxe Rooms', $details['room_type']);
        $this->assertSame(2, (int) $details['guests']);
        $this->assertSame(2, (int) $details['rooms']);
        $this->assertArrayHasKey('check_in', $details);
    }

    public function test_room_enquiry_requires_dates_and_guest_count(): void
    {
        Mail::fake();

        $this->post('/send-enquiry', array_merge($this->payload, [
            'type' => Enquiry::TYPE_ROOM,
        ]))->assertSessionHasErrors([
            'details.check_in',
            'details.check_out',
            'details.guests',
        ]);

        $this->assertSame(0, Enquiry::count());
    }

    public function test_room_enquiry_rejects_checkout_before_checkin(): void
    {
        Mail::fake();

        $this->post('/send-enquiry', $this->roomPayload([
            'check_in' => now()->addDays(5)->format('Y-m-d'),
            'check_out' => now()->addDays(3)->format('Y-m-d'),
        ]))->assertSessionHasErrors('details.check_out');

        $this->assertSame(0, Enquiry::count());
    }

    public function test_room_enquiry_rejects_an_unknown_room_type(): void
    {
        Mail::fake();

        $this->post('/send-enquiry', $this->roomPayload(['room_type' => 'Presidential Penthouse']))
            ->assertSessionHasErrors('details.room_type');

        $this->assertSame(0, Enquiry::count());
    }

    public function test_details_belonging_to_another_type_are_discarded(): void
    {
        Mail::fake();

        // Hidden fields still post, so the server must strip the wedding keys.
        $this->post('/send-enquiry', $this->roomPayload([
            'event_guests' => 300,
            'party_size' => 8,
        ]))->assertSessionHasNoErrors();

        $details = Enquiry::firstOrFail()->details;
        $this->assertArrayNotHasKey('event_guests', $details);
        $this->assertArrayNotHasKey('party_size', $details);
        $this->assertArrayHasKey('guests', $details);
    }

    public function test_wedding_enquiry_stores_its_details(): void
    {
        Mail::fake();
        WeddingHall::create(['name' => 'Grand Hall', 'images' => ['/storage/weddings/a.jpg']]);

        $this->post('/send-enquiry', array_merge($this->payload, [
            'type' => Enquiry::TYPE_WEDDING,
            'details' => [
                'event_date' => now()->addMonths(6)->format('Y-m-d'),
                'event_guests' => 250,
                'hall' => 'Grand Hall',
            ],
        ]))->assertSessionHasNoErrors();

        $details = Enquiry::firstOrFail()->details;
        $this->assertSame('Grand Hall', $details['hall']);
        $this->assertSame(250, (int) $details['event_guests']);
    }

    public function test_wedding_enquiry_requires_date_and_guest_count(): void
    {
        Mail::fake();

        $this->post('/send-enquiry', array_merge($this->payload, [
            'type' => Enquiry::TYPE_WEDDING,
        ]))->assertSessionHasErrors(['details.event_date', 'details.event_guests']);
    }

    public function test_dining_enquiry_stores_its_details(): void
    {
        Mail::fake();

        $this->post('/send-enquiry', array_merge($this->payload, [
            'type' => Enquiry::TYPE_DINING,
            'details' => [
                'dining_date' => now()->addDays(2)->format('Y-m-d'),
                'dining_time' => '19:30',
                'party_size' => 4,
            ],
        ]))->assertSessionHasNoErrors();

        $enquiry = Enquiry::firstOrFail();
        $this->assertSame('19:30', $enquiry->details['dining_time']);
        $this->assertSame('7:30 PM', $enquiry->formatted_details['Time']);
    }

    public function test_dining_enquiry_requires_date_time_and_party_size(): void
    {
        Mail::fake();

        $this->post('/send-enquiry', array_merge($this->payload, [
            'type' => Enquiry::TYPE_DINING,
        ]))->assertSessionHasErrors([
            'details.dining_date',
            'details.dining_time',
            'details.party_size',
        ]);
    }

    public function test_general_enquiry_needs_only_a_message(): void
    {
        Mail::fake();

        $this->post('/send-enquiry', array_merge($this->payload, [
            'type' => Enquiry::TYPE_GENERAL,
        ]))->assertSessionHasNoErrors();

        $enquiry = Enquiry::firstOrFail();
        $this->assertSame([], $enquiry->details);
        $this->assertSame([], $enquiry->formatted_details);
    }

    public function test_general_enquiry_requires_a_message(): void
    {
        Mail::fake();

        $payload = $this->payload;
        unset($payload['message']);

        $this->post('/send-enquiry', array_merge($payload, [
            'type' => Enquiry::TYPE_GENERAL,
        ]))->assertSessionHasErrors('message');
    }

    public function test_message_is_optional_for_a_room_enquiry(): void
    {
        Mail::fake();

        $payload = $this->roomPayload();
        unset($payload['message']);

        $this->post('/send-enquiry', $payload)->assertSessionHasNoErrors();

        $this->assertSame('', Enquiry::firstOrFail()->message);
    }

    public function test_an_unknown_enquiry_type_is_rejected(): void
    {
        Mail::fake();

        $this->post('/send-enquiry', array_merge($this->payload, ['type' => 'Helicopter Charter']))
            ->assertSessionHasErrors('type');
    }

    public function test_contact_page_preselects_type_and_room_from_the_query_string(): void
    {
        RoomType::create(['name' => 'Deluxe Rooms', 'slug' => 'deluxe', 'icon' => '<svg></svg>']);

        $this->get('/contact?type='.urlencode(Enquiry::TYPE_ROOM).'&room_type='.urlencode('Deluxe Rooms'))
            ->assertOk()
            ->assertViewHas('preselectedType', Enquiry::TYPE_ROOM)
            ->assertViewHas('preselectedRoomType', 'Deluxe Rooms')
            ->assertSee('value="Deluxe Rooms" selected', false);
    }

    public function test_contact_page_ignores_an_invalid_type_in_the_query_string(): void
    {
        $this->get('/contact?type=Helicopter+Charter')
            ->assertOk()
            ->assertViewHas('preselectedType', '');
    }

    public function test_contact_form_lists_room_types_from_the_database(): void
    {
        RoomType::create(['name' => 'Treehouse Suite', 'slug' => 'treehouse', 'icon' => '<svg></svg>']);

        $this->get('/contact')->assertOk()->assertSee('Treehouse Suite');
    }
}
