<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Str;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (($data['status'] ?? 'draft') === 'published' && blank($data['excerpt'] ?? null)) {
            $data['excerpt'] = Str::limit(trim(strip_tags((string) ($data['content'] ?? ''))), 180);
        }

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('view_on_site')
                ->label('View on site')
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->url(fn (): string => route('posts.show', ['post' => $this->getRecord()->slug]))
                ->openUrlInNewTab()
                ->visible(fn (): bool => $this->getRecord()->status === 'published'),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Post updated');
    }
}
