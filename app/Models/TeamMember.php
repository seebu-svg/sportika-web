<?php

namespace App\Models;

use App\Models\Concerns\HasSlug;
use App\Models\Concerns\ResolvesImageUrls;
use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    use HasSlug, ResolvesImageUrls;

    protected static string $slugSource = 'name';

    protected $fillable = [
        'name', 'slug', 'designation', 'photo', 'bio',
        'email', 'phone', 'social_links', 'sort_order', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'social_links' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public function getPhotoUrlAttribute(): ?string
    {
        return $this->resolveImageUrl($this->photo);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order')->orderBy('name');
    }
}
