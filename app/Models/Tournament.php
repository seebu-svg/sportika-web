<?php

namespace App\Models;

use App\Models\Concerns\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tournament extends Model
{
    use HasSlug, SoftDeletes;

    protected static string $slugSource = 'name';

    public const STATUSES = ['upcoming', 'ongoing', 'completed'];

    protected $fillable = [
        'name', 'slug', 'sport', 'city', 'start_date', 'end_date',
        'status', 'cover_image', 'description', 'fixtures', 'results',
        'participating_player_ids', 'gallery',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'fixtures' => 'array',
            'results' => 'array',
            'participating_player_ids' => 'array',
            'gallery' => 'array',
        ];
    }

    public function getCoverUrlAttribute(): ?string
    {
        return $this->cover_image ? \Illuminate\Support\Facades\Storage::disk('public')->url($this->cover_image) : null;
    }

    public function scopeUpcoming($query)
    {
        return $query->where('status', 'upcoming');
    }

    public function scopeOngoing($query)
    {
        return $query->where('status', 'ongoing');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function participatingPlayers()
    {
        return Player::whereIn('id', $this->participating_player_ids ?? [])->get();
    }
}
