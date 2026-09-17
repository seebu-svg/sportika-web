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

    public const STATUS_BADGES = ['unverified', 'verified', 'featured'];

    public const LEVELS = ['International', 'National', 'Domestic', 'University', 'College', 'School'];

    public const SPORTS = [
        'Cricket', 'Football', 'Futsal', 'Badminton',
        'Chess', 'Padel', 'MMA', 'Boxing', 'Kabaddi',
        'Volleyball', 'Basketball', 'Tennis', 'Table Tennis',
        'Swimming', 'Athletics', 'Other',
    ];

    protected $fillable = [
        'name',
        'slug',
        'position',
        'sport',
        'jersey_number',
        'nationality',
        'city',
        'level',
        'date_of_birth',
        'height_cm',
        'weight_kg',
        'preferred_foot',
        'current_club',
        'photo',
        'cover_image',
        'short_description',
        'bio',
        'appearances',
        'goals',
        'assists',
        'clean_sheets',
        'honours',
        'achievements',
        'media',
        'press_mentions',
        'social_links',
        'status',
        'status_badge',
        'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date:Y-m-d',
            'honours' => 'array',
            'achievements' => 'array',
            'media' => 'array',
            'press_mentions' => 'array',
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

    public function scopeVerified($query)
    {
        return $query->published()->where('status_badge', 'verified');
    }

    public function getPhotoUrlAttribute(): ?string
    {
        return $this->photo ? \Illuminate\Support\Facades\Storage::disk('public')->url($this->photo) : null;
    }

    public function getCoverImageUrlAttribute(): ?string
    {
        return $this->cover_image ? \Illuminate\Support\Facades\Storage::disk('public')->url($this->cover_image) : null;
    }

    public function getAgeAttribute(): ?int
    {
        return $this->date_of_birth ? $this->date_of_birth->age : null;
    }
}
