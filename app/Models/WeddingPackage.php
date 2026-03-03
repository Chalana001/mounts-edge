<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeddingPackage extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = ['includes' => 'array', 'is_popular' => 'boolean'];
}
