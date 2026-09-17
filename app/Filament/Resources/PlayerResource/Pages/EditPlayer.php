<?php

namespace App\Filament\Resources\PlayerResource\Pages;

use App\Filament\Resources\PlayerResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditPlayer extends EditRecord
{
    protected static string $resource = PlayerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('view_on_site')
                ->label('View on site')
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->url(fn (): string => route('players.show', ['player' => $this->getRecord()->slug]))
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
            ->title('Player updated');
    }
}
