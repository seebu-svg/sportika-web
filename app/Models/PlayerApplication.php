<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlayerApplication extends Model
{
    protected $fillable = [
        'full_name', 'cnic', 'phone', 'date_of_birth', 'height_cm',
        'address', 'city', 'level', 'club_name', 'institution_name',
        'sport', 'sport_details', 'achievements', 'bio', 'images',
        'video_links', 'press_mentions', 'parent_guardian_contact',
        'consent_given', 'status', 'approved_by', 'approved_at', 'player_id',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'sport_details' => 'array',
            'achievements' => 'array',
            'images' => 'array',
            'video_links' => 'array',
            'press_mentions' => 'array',
            'consent_given' => 'boolean',
            'height_cm' => 'integer',
            'approved_at' => 'datetime',
        ];
    }

    public function approvedPlayer(): BelongsTo
    {
        return $this->belongsTo(Player::class, 'player_id');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }
}
