<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PodcastApplicationResource\Pages;
use App\Models\PodcastApplication;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

class PodcastApplicationResource extends Resource
{
    protected static ?string $model = PodcastApplication::class;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';

    protected static ?string $navigationGroup = 'Applications';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationLabel = 'Podcast Applications';

    protected static ?string $modelLabel = 'Podcast Application';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Applicant')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')->required()->maxLength(120),
                        TextInput::make('email')->required()->email()->maxLength(180),
                        TextInput::make('phone')->tel()->maxLength(30),
                        TextInput::make('sport')->maxLength(80),
                        TextInput::make('category')->maxLength(80),
                        TextInput::make('availability')->maxLength(120),
                    ]),

                Section::make('Pitch')
                    ->schema([
                        Textarea::make('pitch')->required()->maxLength(3000)->rows(4),
                        Textarea::make('achievements')->maxLength(2000)->rows(3),
                    ]),

                Section::make('Status')
                    ->columns(2)
                    ->schema([
                        Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'reviewing' => 'Reviewing',
                                'shortlisted' => 'Shortlisted',
                                'rejected' => 'Rejected',
                            ])
                            ->native(false)
                            ->required(),
                        Select::make('player_id')
                            ->label('Linked player')
                            ->relationship('player', 'name')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->placeholder('None'),
                    ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                \Filament\Infolists\Components\Section::make('Applicant')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('name')->weight('semibold'),
                        TextEntry::make('email')->copyable()->icon('heroicon-m-envelope'),
                        TextEntry::make('phone')->copyable()->icon('heroicon-m-phone')->placeholder('—'),
                        TextEntry::make('sport')->badge()->placeholder('—'),
                        TextEntry::make('category')->badge()->color('info')->placeholder('—'),
                        TextEntry::make('availability')->placeholder('—'),
                    ]),
                \Filament\Infolists\Components\Section::make('Pitch')
                    ->schema([
                        TextEntry::make('pitch')->prose()->columnSpanFull(),
                        TextEntry::make('achievements')->prose()->columnSpanFull()->placeholder('—'),
                    ]),
                \Filament\Infolists\Components\Section::make('Status')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'shortlisted' => 'success',
                                'reviewing' => 'info',
                                'rejected' => 'danger',
                                default => 'warning',
                            }),
                        TextEntry::make('created_at')
                            ->label('Submitted')
                            ->dateTime('d M Y, H:i'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('semibold'),
                TextColumn::make('sport')
                    ->badge()
                    ->toggleable(),
                TextColumn::make('category')
                    ->toggleable(),
                TextColumn::make('email')
                    ->copyable()
                    ->toggleable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'shortlisted' => 'success',
                        'reviewing' => 'info',
                        'rejected' => 'danger',
                        default => 'warning',
                    }),
                TextColumn::make('created_at')
                    ->label('Submitted')
                    ->since()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'reviewing' => 'Reviewing',
                        'shortlisted' => 'Shortlisted',
                        'rejected' => 'Rejected',
                    ]),
            ])
            ->actions([
                ViewAction::make(),
                Action::make('shortlist')
                    ->label('Shortlist')
                    ->icon('heroicon-m-star')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function (PodcastApplication $record) {
                        $record->update(['status' => 'shortlisted']);
                        Notification::make()->success()->title('Application shortlisted')->send();
                    })
                    ->visible(fn (PodcastApplication $record): bool => in_array($record->status, ['pending', 'reviewing'])),
                Action::make('reviewing')
                    ->label('Mark reviewing')
                    ->icon('heroicon-m-eye')
                    ->color('info')
                    ->action(function (PodcastApplication $record) {
                        $record->update(['status' => 'reviewing']);
                    })
                    ->visible(fn (PodcastApplication $record): bool => $record->status === 'pending'),
                Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-m-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(function (PodcastApplication $record) {
                        $record->update(['status' => 'rejected']);
                        Notification::make()->success()->title('Application rejected')->send();
                    })
                    ->visible(fn (PodcastApplication $record): bool => in_array($record->status, ['pending', 'reviewing'])),
                Action::make('reply')
                    ->label('Reply')
                    ->icon('heroicon-m-arrow-right-circle')
                    ->color('info')
                    ->url(fn (PodcastApplication $record): string => "mailto:{$record->email}?subject=Re: Podcast Application"),
                Action::make('prioritize')
                    ->label(fn () => 'Priority')
                    ->icon('heroicon-m-arrow-up-circle')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->modalHeading('Move to top of review queue')
                    ->modalDescription('This marks the application as reviewing and brings it to the top.')
                    ->action(function (PodcastApplication $record) {
                        $record->update(['status' => 'reviewing']);
                        Notification::make()
                            ->success()
                            ->title('Application prioritized')
                            ->body('Moved to the top of the review queue.')
                            ->send();
                    })
                    ->visible(fn (PodcastApplication $record): bool => $record->status === 'pending'),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkAction::make('bulk_shortlist')
                    ->label('Shortlist selected')
                    ->icon('heroicon-m-star')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(fn (Collection $records) => $records->each->update(['status' => 'shortlisted']))
                    ->deselectRecordsAfterCompletion(),
                DeleteBulkAction::make(),
            ])
            ->defaultSort('created_at', 'desc')
            ->poll('60s');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPodcastApplications::route('/'),
            'view' => Pages\ViewPodcastApplication::route('/{record}'),
            'edit' => Pages\EditPodcastApplication::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::pending()->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }
}
