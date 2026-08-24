<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeddingPackage extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'guests', 'is_popular', 'includes'];
    protected $casts = ['includes' => 'array', 'is_popular' => 'boolean'];
}
