<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'location',
        'activity_date',
        'image',
        'body',
        'sort_order',
        'is_active',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'meta_image',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'activity_date' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
