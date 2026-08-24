<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Enquiry extends Model
{
    use HasFactory, SoftDeletes;

    public const STATUS_NEW = 'new';
    public const STATUS_CONTACTED = 'contacted';
    public const STATUS_CLOSED = 'closed';

    public const STATUSES = [self::STATUS_NEW, self::STATUS_CONTACTED, self::STATUS_CLOSED];

    public const TYPE_ROOM = 'Room Booking';
    public const TYPE_WEDDING = 'Wedding Inquiry';
    public const TYPE_DINING = 'Dining Reservation';
    public const TYPE_GENERAL = 'General Inquiry';

    public const TYPES = [self::TYPE_ROOM, self::TYPE_WEDDING, self::TYPE_DINING, self::TYPE_GENERAL];

    /**
     * Which detail keys belong to which enquiry type. Used to strip the
     * fields of every other type before saving, so a room enquiry can never
     * store stray wedding answers submitted by a hidden input.
     */
    public const TYPE_DETAIL_KEYS = [
        self::TYPE_ROOM => ['room_type', 'check_in', 'check_out', 'guests', 'rooms'],
        self::TYPE_WEDDING => ['hall', 'package', 'event_date', 'event_guests'],
        self::TYPE_DINING => ['dining_date', 'dining_time', 'party_size'],
        self::TYPE_GENERAL => [],
    ];

    /** Human labels for the stored detail keys, in display order. */
    public const DETAIL_LABELS = [
        'room_type' => 'Room type',
        'check_in' => 'Check-in',
        'check_out' => 'Check-out',
        'guests' => 'Guests',
        'rooms' => 'Rooms needed',
        'hall' => 'Preferred hall',
        'package' => 'Preferred package',
        'event_date' => 'Event date',
        'event_guests' => 'Expected guests',
        'dining_date' => 'Date',
        'dining_time' => 'Time',
        'party_size' => 'Party size',
    ];

    protected $fillable = [
        'name', 'email', 'phone', 'type', 'message', 'details', 'status', 'email_notification_failed',
    ];

    protected $casts = [
        'email_notification_failed' => 'boolean',
        'details' => 'array',
    ];

    /**
     * The stored details keyed by human label, in DETAIL_LABELS order, with
     * dates and times formatted for reading. Admin views and the notification
     * email both loop over this, so neither needs per-type branching.
     *
     * @return array<string, string>
     */
    public function getFormattedDetailsAttribute(): array
    {
        $details = $this->details ?: [];
        $formatted = [];

        foreach (self::DETAIL_LABELS as $key => $label) {
            if (! array_key_exists($key, $details)) {
                continue;
            }

            $formatted[$label] = $this->formatDetailValue($key, $details[$key]);
        }

        return $formatted;
    }

    /**
     * A one-line summary for the admin inbox cards (e.g. "3 guests · 12 Jun → 14 Jun").
     */
    public function getDetailSummaryAttribute(): ?string
    {
        $details = $this->details ?: [];
        $parts = [];

        if (isset($details['guests'])) {
            $parts[] = $details['guests'].' '.\Illuminate\Support\Str::plural('guest', (int) $details['guests']);
        }

        if (isset($details['event_guests'])) {
            $parts[] = $details['event_guests'].' '.\Illuminate\Support\Str::plural('guest', (int) $details['event_guests']);
        }

        if (isset($details['party_size'])) {
            $parts[] = 'Party of '.$details['party_size'];
        }

        if (isset($details['check_in'], $details['check_out'])) {
            $parts[] = $this->formatDetailValue('check_in', $details['check_in'])
                .' → '.$this->formatDetailValue('check_out', $details['check_out']);
        } elseif (isset($details['event_date'])) {
            $parts[] = $this->formatDetailValue('event_date', $details['event_date']);
        } elseif (isset($details['dining_date'])) {
            $parts[] = $this->formatDetailValue('dining_date', $details['dining_date'])
                .(isset($details['dining_time']) ? ' at '.$this->formatDetailValue('dining_time', $details['dining_time']) : '');
        }

        return $parts === [] ? null : implode(' · ', $parts);
    }

    private function formatDetailValue(string $key, mixed $value): string
    {
        if (in_array($key, ['check_in', 'check_out', 'event_date', 'dining_date'], true)) {
            try {
                return \Illuminate\Support\Carbon::parse((string) $value)->format('j M Y');
            } catch (\Throwable) {
                return (string) $value;
            }
        }

        if ($key === 'dining_time') {
            try {
                return \Illuminate\Support\Carbon::createFromFormat('H:i', (string) $value)->format('g:i A');
            } catch (\Throwable) {
                return (string) $value;
            }
        }

        return (string) $value;
    }
}
