<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BrandApplicationResource\Pages;
use App\Models\BrandApplication;
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
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

class BrandApplicationResource extends Resource
{
    protected static ?string $model = BrandApplication::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?string $navigationGroup = 'Applications';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Brand Applications';

    protected static ?string $modelLabel = 'Brand Application';

    protected static ?string $recordTitleAttribute = 'brand_name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Brand')
                    ->columns(2)
                    ->schema([
                        TextInput::make('brand_name')->required()->maxLength(180),
                        TextInput::make('contact_person')->required()->maxLength(120),
                        TextInput::make('email')->required()->email()->maxLength(180),
                        TextInput::make('phone')->tel()->maxLength(30),
                        TextInput::make('website')->url()->maxLength(255),
                        Select::make('interest')
                            ->options([
                                'Sponsorship' => 'Sponsorship',
                                'Partnership' => 'Partnership',
                                'Advertising' => 'Advertising',
                            ])
                            ->native(false),
                    ]),

                Section::make('Details')
                    ->schema([
                        Textarea::make('details')->maxLength(2000)->rows(4),
                        Textarea::make('message')->maxLength(2000)->rows(3),
                    ]),

                Section::make('Status')
                    ->schema([
                        Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'approved' => 'Approved',
                                'rejected' => 'Rejected',
                            ])
                            ->native(false)
                            ->required(),
                    ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                \Filament\Infolists\Components\Section::make('Brand')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('brand_name')->weight('semibold'),
                        TextEntry::make('contact_person'),
                        TextEntry::make('email')->copyable()->icon('heroicon-m-envelope'),
                        TextEntry::make('phone')->copyable()->icon('heroicon-m-phone')->placeholder('—'),
                        TextEntry::make('website')->copyable()->icon('heroicon-m-globe-alt')->placeholder('—'),
                        TextEntry::make('interest')
                            ->badge()
                            ->color(fn (?string $state): string => match ($state) {
                                'Sponsorship' => 'primary',
                                'Partnership' => 'success',
                                default => 'info',
                            }),
                    ]),
                \Filament\Infolists\Components\Section::make('Details')
                    ->schema([
                        TextEntry::make('details')->prose()->columnSpanFull()->placeholder('—'),
                        TextEntry::make('message')->prose()->columnSpanFull()->placeholder('—'),
                    ]),
                \Filament\Infolists\Components\Section::make('Status')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'approved' => 'success',
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
                TextColumn::make('brand_name')
                    ->searchable()
                    ->sortable()
                    ->weight('semibold'),
                TextColumn::make('contact_person')
                    ->searchable(),
                TextColumn::make('email')
                    ->copyable()
                    ->toggleable(),
                TextColumn::make('interest')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'Sponsorship' => 'primary',
                        'Partnership' => 'success',
                        default => 'info',
                    }),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'approved' => 'success',
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
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ]),
                SelectFilter::make('interest')
                    ->options([
                        'Sponsorship' => 'Sponsorship',
                        'Partnership' => 'Partnership',
                        'Advertising' => 'Advertising',
                    ]),
            ])
            ->actions([
                ViewAction::make(),
                Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-m-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function (BrandApplication $record) {
                        $record->update(['status' => 'approved']);
                        Notification::make()->success()->title('Brand application approved')->send();
                    })
                    ->visible(fn (BrandApplication $record): bool => $record->status === 'pending'),
                Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-m-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(function (BrandApplication $record) {
                        $record->update(['status' => 'rejected']);
                        Notification::make()->success()->title('Brand application rejected')->send();
                    })
                    ->visible(fn (BrandApplication $record): bool => $record->status === 'pending'),
                Action::make('reply')
                    ->label('Reply')
                    ->icon('heroicon-m-arrow-right-circle')
                    ->color('info')
                    ->url(fn (BrandApplication $record): string => "mailto:{$record->email}?subject=Re: Partnership Inquiry from {$record->brand_name}"),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkAction::make('bulk_approve')
                    ->label('Approve selected')
                    ->icon('heroicon-m-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(fn (Collection $records) => $records->each->update(['status' => 'approved']))
                    ->deselectRecordsAfterCompletion(),
                DeleteBulkAction::make(),
            ])
            ->defaultSort('created_at', 'desc')
            ->poll('60s');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBrandApplications::route('/'),
            'view' => Pages\ViewBrandApplication::route('/{record}'),
            'edit' => Pages\EditBrandApplication::route('/{record}/edit'),
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
