<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeddingHall extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'tagline', 'description', 'capacity', 'area', 'style', 'image', 'images', 'features'];
    protected $casts = ['features' => 'array', 'images' => 'array'];
}
