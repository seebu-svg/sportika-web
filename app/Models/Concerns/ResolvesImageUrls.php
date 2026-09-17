<?php

namespace App\Models\Concerns;

use Illuminate\Support\Facades\Storage;

/**
 * Resolves image paths to URLs.
 *
 * Supports three storage patterns:
 *  1. External URLs (starts with http/https) — returned as-is.
 *  2. Local paths (e.g. "players/photo.jpg") — resolved via the "public" disk.
 *  3. Null — returns null.
 */
trait ResolvesImageUrls
{
    protected function resolveImageUrl(?string $path): ?string
    {
        if ($path === null || $path === '') {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return Storage::disk('public')->url($path);
    }
}
