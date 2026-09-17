<?php

namespace App\Models;

use App\Models\Concerns\HasSlug;
use App\Models\Concerns\ResolvesImageUrls;
use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    use HasSlug, ResolvesImageUrls;

    protected static string $slugSource = 'name';

    protected $fillable = [
        'name', 'slug', 'logo', 'website', 'category',
        'description', 'sort_order', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function getLogoUrlAttribute(): ?string
    {
        return $this->resolveImageUrl($this->logo);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order')->orderBy('name');
    }
}
