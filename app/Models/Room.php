<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model {
    protected $guarded = [];
    public function roomType() {
        return $this->belongsTo(RoomType::class);
    }
    public function features() {
        return $this->belongsToMany(Feature::class);
    }
}
