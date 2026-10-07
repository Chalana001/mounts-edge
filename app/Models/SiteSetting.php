<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    public const DEFAULTS = [
        // Verified by management 2026-10-01/02 (BUSINESS-TRUTH.md §1).
        // Domain: https://mountsedgeregency.lk — set APP_URL to match at launch.
        'phone_display' => '055 225 6500',
        'phone_link' => '+94552256500',
        // Owner 2026-10-02: monitored WhatsApp 0777403940 (backend-editable).
        'whatsapp_number' => '94777403940',
        // Owner 2026-10-02: official inbox mountedgeregency@gmail.com.
        'public_email' => 'mountedgeregency@gmail.com',
        'notification_email' => 'mountedgeregency@gmail.com',
        'address' => 'Kandy Rd, Gurulupotha, Hasalaka 20960, Mahiyangana, Sri Lanka',
        // Item 2: current map embed query verified by owner — keep DB link
        // generic; live map centres on name+address at runtime.
        'map_url' => 'https://maps.google.com',
    ];

    protected $fillable = [
        'phone_display',
        'phone_link',
        'whatsapp_number',
        'public_email',
        'notification_email',
        'address',
        'map_url',
    ];

    public static function current(): self
    {
        return static::firstOrCreate(['id' => 1], self::DEFAULTS);
    }
}
