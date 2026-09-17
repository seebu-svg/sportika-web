<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryItem extends Model
{
    protected $fillable = [
        'title', 'type', 'file_path', 'album', 'tournament',
        'caption', 'sort_order', 'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
        ];
    }

    public function getFileUrlAttribute(): ?string
    {
        return $this->file_path ? \Illuminate\Support\Facades\Storage::disk('public')->url($this->file_path) : null;
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)->orderBy('sort_order');
    }

    public function scopePhotos($query)
    {
        return $query->where('type', 'photo');
    }

    public function scopeVideos($query)
    {
        return $query->where('type', 'video');
    }
}
