<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = [
        'eyebrow_text',
        'title',
        'description',
        'btn1_text',
        'btn1_url',
        'btn2_text',
        'btn2_url',
        'image',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
