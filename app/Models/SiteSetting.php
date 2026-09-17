<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'site_name',
        'tagline',
        'hero_title',
        'hero_subtitle',
        'about_title',
        'about_body',
        'phone',
        'email',
        'address',
        'facebook_url',
        'twitter_url',
        'instagram_url',
        'linkedin_url',
        'youtube_url',
    ];

    /**
     * The singleton settings row, creating it on first access.
     */
    public static function current(): self
    {
        return static::query()->first() ?? static::create([
            'site_name' => config('app.name', 'Sportika'),
        ]);
    }
}
