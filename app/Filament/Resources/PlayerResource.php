<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlayerResource\Pages;
use App\Models\Player;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class PlayerResource extends Resource
{
    protected static ?string $model = Player::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Content';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Identity')
                    ->description('Basic profile information shown on the players directory.')
                    ->columns(3)
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(120)
                            ->live(onBlur: true)
                            ->hintIcon('heroicon-m-question-mark-circle')
                            ->hintIconTooltip('Leave the slug blank to auto-generate it from the name.'),
                        TextInput::make('slug')
                            ->unique(ignoreRecord: true)
                            ->maxLength(160),
                        Select::make('sport')
                            ->options(array_combine(Player::SPORTS, Player::SPORTS))
                            ->searchable()
                            ->native(false),
                        Select::make('position')
                            ->options(Player::POSITIONS)
                            ->required()
                            ->native(false),
                        TextInput::make('jersey_number')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(99),
                        TextInput::make('nationality')
                            ->maxLength(80),
                        TextInput::make('city')
                            ->maxLength(100),
                        Select::make('level')
                            ->options(array_combine(Player::LEVELS, Player::LEVELS))
                            ->native(false),
                        Select::make('preferred_foot')
                            ->options(Player::FEET)
                            ->native(false),
                    ]),

                Section::make('Profile & photo')
                    ->columns(2)
                    ->schema([
                        FileUpload::make('photo')
                            ->image()
                            ->imageEditor()
                            ->directory('players')
                            ->disk('public')
                            ->visibility('public')
                            ->maxSize(4096)
                            ->imagePreviewHeight('300')
                            ->helperText('Portrait image, ideally 800×1000px. Max 4MB.')
                            ->columnSpan(1),
                        FileUpload::make('cover_image')
                            ->image()
                            ->imageEditor()
                            ->directory('players/covers')
                            ->disk('public')
                            ->visibility('public')
                            ->maxSize(4096)
                            ->helperText('Wide banner image for the player detail page. Max 4MB.'),
                        TextInput::make('short_description')
                            ->maxLength(255)
                            ->helperText('One-liner displayed on directory cards.')
                            ->columnSpanFull(),
                    ]),

                Section::make('Biography')
                    ->schema([
                        RichEditor::make('bio')
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'h2',
                                'h3',
                                'bulletList',
                                'orderedList',
                                'blockquote',
                                'link',
                                'undo',
                                'redo',
                            ])
                            ->columnSpanFull(),
                    ]),

                Section::make('Career & stats')
                    ->columns(3)
                    ->schema([
                        TextInput::make('current_club')
                            ->maxLength(120)
                            ->columnSpan(3),
                        DatePicker::make('date_of_birth')
                            ->maxDate(Carbon::today())
                            ->native(false),
                        TextInput::make('height_cm')
                            ->numeric()
                            ->minValue(100)
                            ->maxValue(250)
                            ->suffix('cm'),
                        TextInput::make('weight_kg')
                            ->numeric()
                            ->minValue(40)
                            ->maxValue(150)
                            ->suffix('kg'),
                        TextInput::make('appearances')
                            ->numeric()
                            ->minValue(0)
                            ->default(0),
                        TextInput::make('goals')
                            ->numeric()
                            ->minValue(0)
                            ->default(0),
                        TextInput::make('assists')
                            ->numeric()
                            ->minValue(0)
                            ->default(0),
                        TextInput::make('clean_sheets')
                            ->numeric()
                            ->minValue(0)
                            ->default(0)
                            ->helperText('Goalkeepers only.'),
                    ]),

                Section::make('Honours, achievements & social links')
                    ->columns(2)
                    ->schema([
                        KeyValue::make('honours')
                            ->keyLabel('Competition / Award')
                            ->valueLabel('Season & Note')
                            ->reorderable()
                            ->columnSpan(1),
                        Repeater::make('achievements')
                            ->schema([
                                TextInput::make('title')->required(),
                                TextInput::make('year'),
                                TextInput::make('level'),
                                Textarea::make('description')->rows(2),
                            ])
                            ->columns(2)
                            ->reorderable()
                            ->columnSpan(1),
                        KeyValue::make('social_links')
                            ->keyLabel('Platform')
                            ->valueLabel('URL')
                            ->reorderable()
                            ->columnSpan(1),
                        Repeater::make('press_mentions')
                            ->schema([
                                TextInput::make('publication'),
                                TextInput::make('link')->url(),
                                TextInput::make('date'),
                            ])
                            ->columns(3)
                            ->reorderable()
                            ->columnSpan(1),
                    ]),

                Section::make('Media & video links')
                    ->collapsed()
                    ->columns(2)
                    ->schema([
                        Repeater::make('media')
                            ->schema([
                                TextInput::make('title'),
                                TextInput::make('url')->url(),
                                Select::make('type')
                                    ->options(['video' => 'Video', 'photo' => 'Photo', 'article' => 'Article'])
                                    ->native(false),
                            ])
                            ->columns(3)
                            ->reorderable()
                            ->columnSpan(1),
                    ]),

                Section::make('Visibility')
                    ->columns(3)
                    ->schema([
                        Select::make('status')
                            ->options(Player::STATUSES)
                            ->default('draft')
                            ->native(false)
                            ->required(),
                        Select::make('status_badge')
                            ->options([
                                'unverified' => 'Unverified',
                                'verified' => 'Verified',
                                'featured' => 'Featured',
                            ])
                            ->default('unverified')
                            ->native(false)
                            ->required(),
                        Toggle::make('is_featured')
                            ->helperText('Featured players appear on the home page hero carousel.'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo')
                    ->circular()
                    ->defaultImageUrl(url('/images/player-fallback.svg')),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('semibold'),
                TextColumn::make('sport')
                    ->badge()
                    ->toggleable(),
                TextColumn::make('position')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Goalkeeper' => 'amber',
                        'Defender' => 'sky',
                        'Midfielder' => 'emerald',
                        'Forward' => 'rose',
                        default => 'gray',
                    }),
                TextColumn::make('nationality')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('current_club')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('status_badge')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'verified' => 'success',
                        'featured' => 'primary',
                        default => 'gray',
                    }),
                IconColumn::make('is_featured')
                    ->boolean()
                    ->label('Featured'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'published' ? 'success' : 'gray'),
                TextColumn::make('updated_at')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(Player::STATUSES),
                SelectFilter::make('status_badge')
                    ->options([
                        'unverified' => 'Unverified',
                        'verified' => 'Verified',
                        'featured' => 'Featured',
                    ]),
                SelectFilter::make('sport')
                    ->options(array_combine(Player::SPORTS, Player::SPORTS)),
                SelectFilter::make('position')
                    ->options(Player::POSITIONS),
                TrashedFilter::make(),
            ])
            ->actions([
                EditAction::make(),
                RestoreAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    RestoreBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('updated_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPlayers::route('/'),
            'create' => Pages\CreatePlayer::route('/create'),
            'edit' => Pages\EditPlayer::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'nationality', 'current_club'];
    }
}
