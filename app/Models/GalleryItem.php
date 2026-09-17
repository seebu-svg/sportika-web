<?php

namespace App\Models;

use App\Models\Concerns\ResolvesImageUrls;
use Illuminate\Database\Eloquent\Model;

class GalleryItem extends Model
{
    use ResolvesImageUrls;
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
        return $this->resolveImageUrl($this->file_path);
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
