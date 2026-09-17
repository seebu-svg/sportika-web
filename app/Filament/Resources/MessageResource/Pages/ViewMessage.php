<?php

namespace App\Filament\Resources\MessageResource\Pages;

use App\Filament\Resources\MessageResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewMessage extends ViewRecord
{
    protected static string $resource = MessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('mark_unread')
                ->label('Mark unread')
                ->icon('heroicon-m-arrow-uturn-left')
                ->color('gray')
                ->action(function () {
                    $this->getRecord()->markAsUnread();
                    Notification::make()->title('Marked as unread')->send();
                })
                ->visible(fn (): bool => $this->getRecord()->is_read),
            Actions\Action::make('reply')
                ->label('Reply by email')
                ->icon('heroicon-m-arrow-right-circle')
                ->color('info')
                ->url(fn (): string => 'mailto:'.$this->getRecord()->email.'?subject=Re: '.$this->getRecord()->subject),
            Actions\DeleteAction::make(),
        ];
    }

    public function mount(int|string $record): void
    {
        parent::mount($record);

        // Opening a message in the inbox marks it as read.
        $this->getRecord()->markAsRead();
    }
}
