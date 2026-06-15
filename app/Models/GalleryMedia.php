<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryMedia extends Model
{
    protected $fillable = ['gallery_id', 'type', 'file', 'youtube_url', 'sort_order'];

    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }

    public function getYoutubeIdAttribute()
    {
        if (!$this->youtube_url) return null;
        preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([^&\s]+)/', $this->youtube_url, $matches);
        return $matches[1] ?? null;
    }
}
