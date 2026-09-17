<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlayerResource\Pages;
use App\Models\Player;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
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
                        Grid::make(1)->schema([
                            TextInput::make('short_description')
                                ->maxLength(255)
                                ->helperText('One-liner displayed on directory cards.'),
                        ]),
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

                Section::make('Honours & social links')
                    ->columns(2)
                    ->schema([
                        KeyValue::make('honours')
                            ->keyLabel('Competition / Award')
                            ->valueLabel('Season & Note')
                            ->reorderable()
                            ->columnSpan(1),
                        KeyValue::make('social_links')
                            ->keyLabel('Platform')
                            ->valueLabel('URL')
                            ->reorderable()
                            ->columnSpan(1),
                    ]),

                Section::make('Visibility')
                    ->columns(2)
                    ->schema([
                        Select::make('status')
                            ->options(Player::STATUSES)
                            ->default('draft')
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
                SelectFilter::make('position')
                    ->options(Player::POSITIONS),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
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
