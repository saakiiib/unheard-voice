<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = ['title', 'slug', 'cover_image', 'description', 'is_active', 'sort_order'];

    protected $casts = ['is_active' => 'boolean'];

    public function media()
    {
        return $this->hasMany(GalleryMedia::class)->orderBy('sort_order');
    }
}
