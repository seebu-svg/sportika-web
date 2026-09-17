<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['author_id'] ??= Auth::id();

        return $this->fillDerivedFields($data);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Post created')
            ->body(fn () => $this->record->status === 'published'
                ? 'It is now visible on the news page.'
                : 'Publish it from the article list to make it visible.');
    }

    /**
     * Derive the excerpt automatically when publishing with a blank summary.
     */
    protected function fillDerivedFields(array $data): array
    {
        if (($data['status'] ?? 'draft') === 'published' && blank($data['excerpt'] ?? null)) {
            $data['excerpt'] = Str::limit(trim(strip_tags((string) ($data['content'] ?? ''))), 180);
        }

        return $data;
    }
}
