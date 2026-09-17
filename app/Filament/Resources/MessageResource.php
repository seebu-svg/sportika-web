<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MessageResource\Pages;
use App\Models\Message;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

class MessageResource extends Resource
{
    protected static ?string $model = Message::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $navigationGroup = 'Community';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'subject';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required()->maxLength(120),
                TextInput::make('email')->required()->email()->maxLength(180),
                TextInput::make('phone')->tel()->maxLength(30),
                TextInput::make('subject')->required()->maxLength(180),
                Textarea::make('message')->required()->rows(6),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Sender')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('name')
                            ->weight('semibold'),
                        TextEntry::make('email')
                            ->copyable()
                            ->icon('heroicon-m-envelope'),
                        TextEntry::make('phone')
                            ->copyable()
                            ->icon('heroicon-m-phone')
                            ->placeholder('—'),
                    ]),
                Section::make('Message')
                    ->schema([
                        TextEntry::make('subject')
                            ->weight('semibold'),
                        TextEntry::make('message')
                            ->html(false)
                            ->prose()
                            ->columnSpanFull(),
                        Grid::make(2)->schema([
                            TextEntry::make('created_at')
                                ->label('Received')
                                ->dateTime('d M Y, H:i'),
                            TextEntry::make('read_at')
                                ->label('Read at')
                                ->dateTime('d M Y, H:i')
                                ->placeholder('Not read yet'),
                        ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                IconColumn::make('is_read')
                    ->label('')
                    ->boolean()
                    ->trueIcon('heroicon-o-envelope-open')
                    ->falseIcon('heroicon-o-envelope')
                    ->trueColor('gray')
                    ->falseColor('warning'),
                TextColumn::make('name')
                    ->searchable()
                    ->weight(fn (Message $record): string => $record->is_read ? 'normal' : 'semibold'),
                TextColumn::make('subject')
                    ->searchable()
                    ->limit(40)
                    ->weight(fn (Message $record): string => $record->is_read ? 'normal' : 'semibold'),
                TextColumn::make('email')
                    ->toggleable()
                    ->copyable(),
                TextColumn::make('created_at')
                    ->label('Received')
                    ->since()
                    ->sortable(),
            ])
            ->filters([
                TernaryFilter::make('is_read')
                    ->label('Read status')
                    ->trueLabel('Read')
                    ->falseLabel('Unread'),
            ])
            ->actions([
                ViewAction::make(),
                Action::make('mark_read')
                    ->label('Mark read')
                    ->icon('heroicon-m-check')
                    ->color('success')
                    ->requiresConfirmation(false)
                    ->action(fn (Message $record) => $record->markAsRead())
                    ->visible(fn (Message $record): bool => ! $record->is_read),
                Action::make('mark_unread')
                    ->label('Mark unread')
                    ->icon('heroicon-m-arrow-uturn-left')
                    ->color('gray')
                    ->action(fn (Message $record) => $record->markAsUnread())
                    ->visible(fn (Message $record): bool => $record->is_read),
                Action::make('reply')
                    ->label('Reply')
                    ->icon('heroicon-m-arrow-right-circle')
                    ->color('info')
                    ->url(fn (Message $record): string => "mailto:{$record->email}?subject=Re: {$record->subject}"),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkAction::make('mark_read_bulk')
                    ->label('Mark as read')
                    ->icon('heroicon-m-check')
                    ->action(fn (Collection $records) => $records->each->markAsRead())
                    ->deselectRecordsAfterCompletion(),
                BulkAction::make('mark_unread_bulk')
                    ->label('Mark as unread')
                    ->icon('heroicon-m-arrow-uturn-left')
                    ->action(fn (Collection $records) => $records->each->markAsUnread())
                    ->deselectRecordsAfterCompletion(),
                DeleteBulkAction::make(),
            ])
            ->defaultSort('created_at', 'desc')
            ->poll('60s');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMessages::route('/'),
            'view' => Pages\ViewMessage::route('/{record}'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::unread()->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }
}
