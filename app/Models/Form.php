<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;

    protected $table = 'forms';

    protected $fillable = [
        'title',
        'slug',
        'json_data',
        'is_active',
    ];

    protected $casts = [
        'json_data' => 'array',
        'is_active' => 'boolean',
    ];
}


