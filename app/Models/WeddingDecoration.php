<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeddingDecoration extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'tagline', 'description', 'image', 'list_title', 'list_items', 'tags'];
    protected $casts = ['list_items' => 'array', 'tags' => 'array'];
}
