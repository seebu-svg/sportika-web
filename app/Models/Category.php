<?php

namespace App\Models;

use App\Models\Concerns\HasSlug;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory, HasSlug, SoftDeletes;

    protected static string $slugSource = 'name';

    protected $fillable = ['name', 'slug'];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function publishedPosts(): HasMany
    {
        return $this->posts()->published();
    }

    public function scopeWithPublishedPostCounts(Builder $query): Builder
    {
        return $query->withCount(['posts as published_posts_count' => fn (Builder $q) => $q->published()]);
    }
}
