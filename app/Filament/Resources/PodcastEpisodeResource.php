<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PodcastEpisodeResource\Pages;
use App\Models\PodcastEpisode;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
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
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PodcastEpisodeResource extends Resource
{
    protected static ?string $model = PodcastEpisode::class;

    protected static ?string $navigationIcon = 'heroicon-o-microphone';

    protected static ?string $navigationGroup = 'Content';

    protected static ?int $navigationSort = 9;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Episode')
                    ->columns(2)
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(200)
                            ->live(onBlur: true)
                            ->hintIcon('heroicon-m-question-mark-circle')
                            ->hintIconTooltip('Leave the slug blank to auto-generate from the title.'),
                        TextInput::make('slug')
                            ->unique(ignoreRecord: true)
                            ->maxLength(220),
                        TextInput::make('guest_name')
                            ->maxLength(120)
                            ->helperText('Name of the guest (if not linked to a player below).'),
                        Select::make('guest_player_id')
                            ->label('Linked player')
                            ->relationship('guestPlayer', 'name')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->placeholder('None'),
                        DatePicker::make('published_at')
                            ->native(false)
                            ->default(now()),
                        Toggle::make('is_published')
                            ->default(false)
                            ->helperText('Unpublished episodes are hidden from the public podcast page.'),
                    ]),

                Section::make('Thumbnail')
                    ->schema([
                        FileUpload::make('thumbnail')
                            ->image()
                            ->imageEditor()
                            ->directory('podcasts')
                            ->disk('public')
                            ->visibility('public')
                            ->maxSize(4096)
                            ->helperText('Episode thumbnail, ideally 1200×1200px. Max 4MB.'),
                    ]),

                Section::make('Description')
                    ->schema([
                        Textarea::make('description')
                            ->maxLength(3000)
                            ->rows(5),
                    ]),

                Section::make('Streaming links')
                    ->columns(3)
                    ->schema([
                        TextInput::make('youtube_url')
                            ->url()
                            ->maxLength(500)
                            ->prefixIcon('heroicon-m-globe-alt'),
                        TextInput::make('spotify_url')
                            ->url()
                            ->maxLength(500),
                        TextInput::make('apple_url')
                            ->url()
                            ->maxLength(500),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumbnail')
                    ->rounded()
                    ->defaultImageUrl(url('/images/wolf-favicon.png')),
                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->weight('semibold')
                    ->limit(50),
                TextColumn::make('guest_name')
                    ->searchable()
                    ->placeholder('—'),
                TextColumn::make('guestPlayer.name')
                    ->label('Linked player')
                    ->toggleable(),
                TextColumn::make('published_at')
                    ->dateTime('d M Y')
                    ->sortable(),
                IconColumn::make('is_published')
                    ->boolean()
                    ->label('Published'),
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
            ->defaultSort('published_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPodcastEpisodes::route('/'),
            'create' => Pages\CreatePodcastEpisode::route('/create'),
            'edit' => Pages\EditPodcastEpisode::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'guest_name'];
    }
}
