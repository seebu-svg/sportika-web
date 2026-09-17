<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Auto-generates a unique slug from a source column when it is left blank.
 * Define `protected static string $slugSource = 'title';` on the model.
 */
trait HasSlug
{
    public static function bootHasSlug(): void
    {
        static::creating(function (Model $model) {
            if (blank($model->slug)) {
                $model->slug = static::generateUniqueSlug($model->{static::$slugSource});
            }
        });

        static::updating(function (Model $model) {
            if ($model->isDirty(static::$slugSource) && ! $model->isDirty('slug')) {
                $model->slug = static::generateUniqueSlug($model->{static::$slugSource}, $model->getKey());
            }
        });
    }

    public static function generateUniqueSlug(string $source, ?int $ignoreId = null): string
    {
        $base = Str::slug($source) ?: 'item';
        $slug = $base;
        $suffix = 2;

        while (static::query()
            ->where('slug', $slug)
            ->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))
            ->exists()) {
            $slug = "{$base}-{$suffix}";
            $suffix++;
        }

        return $slug;
    }
}
