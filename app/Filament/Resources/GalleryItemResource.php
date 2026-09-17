<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GalleryItemResource\Pages;
use App\Models\GalleryItem;
use Filament\Forms\Components\FileUpload;
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

class GalleryItemResource extends Resource
{
    protected static ?string $model = GalleryItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationGroup = 'Content';

    protected static ?int $navigationSort = 6;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Media')
                    ->columns(2)
                    ->schema([
                        FileUpload::make('file_path')
                            ->required()
                            ->disk('public')
                            ->visibility('public')
                            ->directory('gallery')
                            ->maxSize(10240)
                            ->acceptedFileTypes(['image/*', 'video/*'])
                            ->helperText('Upload a photo or video. Max 10MB.')
                            ->columnSpan(1),
                        TextInput::make('title')
                            ->maxLength(180)
                            ->columnSpan(1),
                        Select::make('type')
                            ->options(['photo' => 'Photo', 'video' => 'Video'])
                            ->default('photo')
                            ->native(false)
                            ->required(),
                        TextInput::make('album')
                            ->maxLength(120)
                            ->helperText('Group items into albums (e.g. "Season 2026 Finals").'),
                        TextInput::make('tournament')
                            ->maxLength(180)
                            ->helperText('Link to a tournament name if applicable.'),
                    ]),

                Section::make('Details')
                    ->columns(2)
                    ->schema([
                        TextInput::make('caption')
                            ->maxLength(500)
                            ->columnSpanFull(),
                        TextInput::make('sort_order')
                            ->numeric()
                            ->default(0)
                            ->helperText('Lower numbers appear first.'),
                        Toggle::make('is_featured')
                            ->helperText('Featured items appear in the gallery highlight section.'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('file_path')
                    ->label('Preview')
                    ->rounded()
                    ->limit(40),
                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->weight('semibold')
                    ->placeholder('Untitled'),
                TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'video' ? 'info' : 'gray'),
                TextColumn::make('album')
                    ->badge()
                    ->toggleable(),
                TextColumn::make('tournament')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('sort_order')
                    ->sortable()
                    ->toggleable(),
                IconColumn::make('is_featured')
                    ->boolean()
                    ->label('Featured'),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->options(['photo' => 'Photo', 'video' => 'Video']),
                SelectFilter::make('is_featured')
                    ->label('Featured')
                    ->options(['1' => 'Featured', '0' => 'Not featured']),
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
            ->defaultSort('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGalleryItems::route('/'),
            'create' => Pages\CreateGalleryItem::route('/create'),
            'edit' => Pages\EditGalleryItem::route('/{record}/edit'),
        ];
    }
}
