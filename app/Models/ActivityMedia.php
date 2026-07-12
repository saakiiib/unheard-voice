<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityMedia extends Model
{
    protected $fillable = ['activity_id', 'type', 'file', 'youtube_url', 'sort_order'];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function getYoutubeIdAttribute()
    {
        if (!$this->youtube_url) return null;
        preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([^&\s]+)/', $this->youtube_url, $matches);
        return $matches[1] ?? null;
    }
}
