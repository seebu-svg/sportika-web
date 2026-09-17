<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlayerApplicationResource\Pages;
use App\Models\Player;
use App\Models\PlayerApplication;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
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
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class PlayerApplicationResource extends Resource
{
    protected static ?string $model = PlayerApplication::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static ?string $navigationGroup = 'Applications';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Player Applications';

    protected static ?string $modelLabel = 'Player Application';

    protected static ?string $recordTitleAttribute = 'full_name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Applicant')
                    ->columns(2)
                    ->schema([
                        TextInput::make('full_name')->required()->maxLength(120),
                        TextInput::make('cnic')->maxLength(20),
                        TextInput::make('phone')->required()->tel()->maxLength(30),
                        DatePicker::make('date_of_birth')->native(false),
                        TextInput::make('height_cm')->numeric()->minValue(100)->maxValue(250)->suffix('cm'),
                        TextInput::make('address')->maxLength(500),
                        TextInput::make('city')->maxLength(100),
                        TextInput::make('parent_guardian_contact')->maxLength(255),
                    ]),

                Section::make('Sport')
                    ->columns(2)
                    ->schema([
                        Select::make('sport')
                            ->options(array_combine(Player::SPORTS, Player::SPORTS))
                            ->searchable()
                            ->native(false)
                            ->required(),
                        Select::make('level')
                            ->options(array_combine(Player::LEVELS, Player::LEVELS))
                            ->native(false),
                        TextInput::make('club_name')->maxLength(255),
                        TextInput::make('institution_name')->maxLength(255),
                    ]),

                Section::make('Bio & achievements')
                    ->schema([
                        Textarea::make('bio')->maxLength(2000)->rows(4),
                        Textarea::make('achievements')->maxLength(2000)->rows(3)
                            ->helperText('One achievement per line.'),
                    ]),

                Section::make('Media')
                    ->collapsed()
                    ->columns(2)
                    ->schema([
                        FileUpload::make('images')
                            ->multiple()
                            ->image()
                            ->directory('applications/players')
                            ->disk('public')
                            ->visibility('public')
                            ->maxFiles(5),
                        Textarea::make('video_links')->rows(3)
                            ->helperText('One URL per line.'),
                        Textarea::make('press_mentions')->rows(3)
                            ->helperText('One mention per line.'),
                    ]),

                Section::make('Consent & status')
                    ->columns(2)
                    ->schema([
                        Toggle::make('consent_given')->default(false),
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
                \Filament\Infolists\Components\Section::make('Applicant')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('full_name')->weight('semibold'),
                        TextEntry::make('phone')->copyable()->icon('heroicon-m-phone'),
                        TextEntry::make('cnic')->placeholder('—'),
                        TextEntry::make('date_of_birth')->date('d M Y')->placeholder('—'),
                        TextEntry::make('height_cm')->suffix(' cm')->placeholder('—'),
                        TextEntry::make('city')->placeholder('—'),
                        TextEntry::make('address')->placeholder('—')->columnSpanFull(),
                    ]),
                \Filament\Infolists\Components\Section::make('Sport')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('sport')->badge(),
                        TextEntry::make('level')->badge()->color('info'),
                        TextEntry::make('club_name')->placeholder('—'),
                        TextEntry::make('institution_name')->placeholder('—'),
                    ]),
                \Filament\Infolists\Components\Section::make('Bio')
                    ->schema([
                        TextEntry::make('bio')->prose()->columnSpanFull(),
                    ]),
                \Filament\Infolists\Components\Section::make('Status')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'approved' => 'success',
                                'rejected' => 'danger',
                                default => 'warning',
                            }),
                        TextEntry::make('created_at')->label('Submitted')->dateTime('d M Y, H:i'),
                        TextEntry::make('consent_given')->badge()->formatStateUsing(fn (bool $state) => $state ? 'Yes' : 'No'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('full_name')
                    ->searchable()
                    ->sortable()
                    ->weight('semibold'),
                TextColumn::make('sport')
                    ->badge(),
                TextColumn::make('level')
                    ->badge()
                    ->color('info')
                    ->toggleable(),
                TextColumn::make('phone')
                    ->copyable()
                    ->toggleable(),
                TextColumn::make('city')
                    ->toggleable(),
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
                SelectFilter::make('sport')
                    ->options(array_combine(Player::SPORTS, Player::SPORTS)),
            ])
            ->actions([
                ViewAction::make(),
                Action::make('approve')
                    ->label('Approve & Create Player')
                    ->icon('heroicon-m-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Approve application & create Player profile')
                    ->modalDescription('This will auto-generate a Player profile from the submitted data. You can edit it afterwards.')
                    ->modalSubmitActionLabel('Yes, approve')
                    ->action(function (PlayerApplication $record) {
                        if ($record->status === 'approved') {
                            Notification::make()
                                ->warning()
                                ->title('Already approved')
                                ->send();

                            return;
                        }

                        DB::transaction(function () use ($record) {
                            $player = Player::create([
                                'name' => $record->full_name,
                                'sport' => $record->sport,
                                'position' => 'Forward',
                                'nationality' => null,
                                'city' => $record->city,
                                'level' => $record->level,
                                'date_of_birth' => $record->date_of_birth,
                                'height_cm' => $record->height_cm,
                                'current_club' => $record->club_name,
                                'short_description' => null,
                                'bio' => $record->bio,
                                'photo' => $record->images[0] ?? null,
                                'status' => 'published',
                                'status_badge' => 'verified',
                                'is_featured' => false,
                            ]);

                            $record->update([
                                'status' => 'approved',
                                'approved_by' => Auth::id(),
                                'approved_at' => Carbon::now(),
                                'player_id' => $player->id,
                            ]);
                        });

                        Notification::make()
                            ->success()
                            ->title('Application approved')
                            ->body('A Player profile has been created from this application.')
                            ->send();
                    })
                    ->visible(fn (PlayerApplication $record): bool => $record->status === 'pending'),
                Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-m-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Reject this application?')
                    ->modalDescription('The applicant will not be notified automatically.')
                    ->modalSubmitActionLabel('Yes, reject')
                    ->action(function (PlayerApplication $record) {
                        $record->update([
                            'status' => 'rejected',
                            'approved_by' => Auth::id(),
                            'approved_at' => Carbon::now(),
                        ]);

                        Notification::make()
                            ->success()
                            ->title('Application rejected')
                            ->send();
                    })
                    ->visible(fn (PlayerApplication $record): bool => $record->status === 'pending'),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkAction::make('bulk_approve')
                    ->label('Approve selected')
                    ->icon('heroicon-m-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function (Collection $records) {
                        foreach ($records->where('status', 'pending') as $record) {
                            DB::transaction(function () use ($record) {
                                $player = Player::create([
                                    'name' => $record->full_name,
                                    'sport' => $record->sport,
                                    'position' => 'Forward',
                                    'city' => $record->city,
                                    'level' => $record->level,
                                    'date_of_birth' => $record->date_of_birth,
                                    'height_cm' => $record->height_cm,
                                    'current_club' => $record->club_name,
                                    'bio' => $record->bio,
                                    'photo' => $record->images[0] ?? null,
                                    'status' => 'published',
                                    'status_badge' => 'verified',
                                    'is_featured' => false,
                                ]);

                                $record->update([
                                    'status' => 'approved',
                                    'approved_by' => Auth::id(),
                                    'approved_at' => Carbon::now(),
                                    'player_id' => $player->id,
                                ]);
                            });
                        }

                        Notification::make()
                            ->success()
                            ->title('Selected applications approved')
                            ->body('Player profiles have been created.')
                            ->send();
                    })
                    ->deselectRecordsAfterCompletion(),
                DeleteBulkAction::make(),
            ])
            ->defaultSort('created_at', 'desc')
            ->poll('60s');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPlayerApplications::route('/'),
            'view' => Pages\ViewPlayerApplication::route('/{record}'),
            'edit' => Pages\EditPlayerApplication::route('/{record}/edit'),
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
