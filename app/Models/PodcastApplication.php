<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PodcastApplication extends Model
{
    protected $fillable = [
        'name', 'email', 'phone', 'sport', 'category',
        'pitch', 'achievements', 'availability',
        'player_id', 'status',
    ];

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
