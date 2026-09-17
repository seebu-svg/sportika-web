<?php

namespace App\Models;

use App\Models\Concerns\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Player extends Model
{
    /** @use HasFactory<\Database\Factories\PlayerFactory> */
    use HasFactory, HasSlug, SoftDeletes;

    protected static string $slugSource = 'name';

    public const POSITIONS = ['Goalkeeper', 'Defender', 'Midfielder', 'Forward'];

    public const FEET = ['Left', 'Right', 'Both'];

    public const STATUSES = ['draft', 'published'];

    protected $fillable = [
        'name',
        'slug',
        'position',
        'jersey_number',
        'nationality',
        'date_of_birth',
        'height_cm',
        'weight_kg',
        'preferred_foot',
        'current_club',
        'photo',
        'short_description',
        'bio',
        'appearances',
        'goals',
        'assists',
        'clean_sheets',
        'honours',
        'social_links',
        'status',
        'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date:Y-m-d',
            'honours' => 'array',
            'social_links' => 'array',
            'is_featured' => 'boolean',
            'jersey_number' => 'integer',
            'height_cm' => 'integer',
            'weight_kg' => 'integer',
            'appearances' => 'integer',
            'goals' => 'integer',
            'assists' => 'integer',
            'clean_sheets' => 'integer',
        ];
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeFeatured($query)
    {
        return $query->published()->where('is_featured', true);
    }

    public function getPhotoUrlAttribute(): ?string
    {
        return $this->photo ? \Illuminate\Support\Facades\Storage::disk('public')->url($this->photo) : null;
    }

    public function getAgeAttribute(): ?int
    {
        return $this->date_of_birth ? $this->date_of_birth->age : null;
    }
}
