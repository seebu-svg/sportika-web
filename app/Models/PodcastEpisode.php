<?php

namespace App\Models;

use App\Models\Concerns\HasSlug;
use App\Models\Concerns\ResolvesImageUrls;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PodcastEpisode extends Model
{
    use HasSlug, ResolvesImageUrls;

    protected static string $slugSource = 'title';

    protected $fillable = [
        'title', 'slug', 'description', 'thumbnail', 'guest_name',
        'guest_player_id', 'youtube_url', 'spotify_url', 'apple_url',
        'published_at', 'is_published',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'date',
            'is_published' => 'boolean',
        ];
    }

    public function guestPlayer(): BelongsTo
    {
        return $this->belongsTo(Player::class, 'guest_player_id');
    }

    public function getThumbnailUrlAttribute(): ?string
    {
        return $this->resolveImageUrl($this->thumbnail);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)->latest('published_at');
    }
}
