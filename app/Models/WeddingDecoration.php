<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeddingDecoration extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = ['list_items' => 'array', 'tags' => 'array'];
}
