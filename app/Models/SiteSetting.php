<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    public const DEFAULTS = [
        'phone_display' => '055 2 256 500',
        'phone_link' => '+94552256500',
        'whatsapp_number' => '94704589764',
        'public_email' => 'ckalhara7277@gmail.com',
        'notification_email' => 'info@mountsedgeregency.com',
        'address' => 'Gurulupotha, Hasalaka, Mahiyangana, Sri Lanka',
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
