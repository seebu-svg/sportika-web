<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TournamentResource\Pages;
use App\Models\Player;
use App\Models\Tournament;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TournamentResource extends Resource
{
    protected static ?string $model = Tournament::class;

    protected static ?string $navigationIcon = 'heroicon-o-trophy';

    protected static ?string $navigationGroup = 'Content';

    protected static ?int $navigationSort = 5;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Details')
                    ->description('Core tournament information displayed on listing and detail pages.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(180)
                            ->live(onBlur: true)
                            ->hintIcon('heroicon-m-question-mark-circle')
                            ->hintIconTooltip('Leave the slug blank to auto-generate from the name.'),
                        TextInput::make('slug')
                            ->unique(ignoreRecord: true)
                            ->maxLength(200),
                        TextInput::make('sport')
                            ->maxLength(80),
                        TextInput::make('city')
                            ->maxLength(100),
                        DatePicker::make('start_date')
                            ->native(false),
                        DatePicker::make('end_date')
                            ->native(false),
                        Select::make('status')
                            ->options(Tournament::STATUSES)
                            ->default('upcoming')
                            ->native(false)
                            ->required(),
                    ]),

                Section::make('Cover image')
                    ->schema([
                        FileUpload::make('cover_image')
                            ->image()
                            ->imageEditor()
                            ->directory('tournaments')
                            ->disk('public')
                            ->visibility('public')
                            ->maxSize(4096)
                            ->helperText('Wide banner image for the tournament. Max 4MB.'),
                    ]),

                Section::make('Description')
                    ->schema([
                        RichEditor::make('description')
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsDirectory('tournaments/attachments')
                            ->fileAttachmentsVisibility('public')
                            ->toolbarButtons([
                                'bold', 'italic', 'underline', 'h2', 'h3',
                                'bulletList', 'orderedList', 'link', 'blockquote',
                                'undo', 'redo',
                            ])
                            ->columnSpanFull(),
                    ]),

                Section::make('Fixtures')
                    ->collapsed()
                    ->schema([
                        Repeater::make('fixtures')
                            ->schema([
                                TextInput::make('match')->placeholder('e.g. Match 1'),
                                TextInput::make('team_a'),
                                TextInput::make('team_b'),
                                TextInput::make('venue'),
                                TextInput::make('date'),
                                TextInput::make('time'),
                            ])
                            ->columns(3)
                            ->reorderable()
                            ->columnSpanFull(),
                    ]),

                Section::make('Results')
                    ->collapsed()
                    ->schema([
                        Repeater::make('results')
                            ->schema([
                                TextInput::make('match'),
                                TextInput::make('team_a'),
                                TextInput::make('score_a'),
                                TextInput::make('team_b'),
                                TextInput::make('score_b'),
                                TextInput::make('summary')->placeholder('e.g. Won by 5 runs'),
                            ])
                            ->columns(3)
                            ->reorderable()
                            ->columnSpanFull(),
                    ]),

                Section::make('Gallery')
                    ->collapsed()
                    ->schema([
                        FileUpload::make('gallery')
                            ->multiple()
                            ->image()
                            ->directory('tournaments/gallery')
                            ->disk('public')
                            ->visibility('public')
                            ->maxSize(4096)
                            ->maxFiles(20)
                            ->helperText('Upload multiple images for the tournament gallery.'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('cover_image')
                    ->rounded()
                    ->defaultImageUrl(url('/images/post-fallback.svg')),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('semibold'),
                TextColumn::make('sport')
                    ->badge()
                    ->toggleable(),
                TextColumn::make('city')
                    ->toggleable(),
                TextColumn::make('start_date')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->label('Start'),
                TextColumn::make('end_date')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->label('End'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'ongoing' => 'warning',
                        'completed' => 'success',
                        default => 'info',
                    }),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(Tournament::STATUSES),
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
            ->defaultSort('start_date', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTournaments::route('/'),
            'create' => Pages\CreateTournament::route('/create'),
            'edit' => Pages\EditTournament::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'sport', 'city'];
    }
}
