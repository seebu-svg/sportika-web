<?php

namespace App\Models;

use App\Models\Concerns\ResolvesImageUrls;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use ResolvesImageUrls;

    protected $fillable = [
        'site_name',
        'tagline',
        'logo',
        'hero_title',
        'hero_subtitle',
        'hero_image',
        'about_title',
        'about_body',
        'about_image',
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

    public function getLogoUrlAttribute(): ?string
    {
        return $this->resolveImageUrl($this->logo);
    }

    public function getHeroImageUrlAttribute(): ?string
    {
        return $this->resolveImageUrl($this->hero_image);
    }

    public function getAboutImageUrlAttribute(): ?string
    {
        return $this->resolveImageUrl($this->about_image);
    }
}
