<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model {
    protected $fillable = ['room_type_id', 'name', 'tagline', 'description', 'image', 'images', 'capacity', 'size'];
    protected $casts = ['images' => 'array'];
    public function roomType() {
        return $this->belongsTo(RoomType::class);
    }
    public function features() {
        return $this->belongsToMany(Feature::class);
    }
}
