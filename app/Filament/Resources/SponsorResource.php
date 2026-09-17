<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SponsorResource\Pages;
use App\Models\Sponsor;
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
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class SponsorResource extends Resource
{
    protected static ?string $model = Sponsor::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';

    protected static ?string $navigationGroup = 'Content';

    protected static ?int $navigationSort = 7;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Sponsor / Partner')
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
                        TextInput::make('website')
                            ->url()
                            ->maxLength(255)
                            ->prefixIcon('heroicon-m-globe-alt'),
                        Select::make('category')
                            ->options([
                                'title' => 'Title Sponsor',
                                'gold' => 'Gold',
                                'silver' => 'Silver',
                                'bronze' => 'Bronze',
                                'partner' => 'Partner',
                            ])
                            ->native(false)
                            ->placeholder('Select tier'),
                        TextInput::make('sort_order')
                            ->numeric()
                            ->default(0)
                            ->helperText('Lower numbers appear first.'),
                        Toggle::make('is_active')
                            ->default(true)
                            ->helperText('Inactive sponsors are hidden from the public page.'),
                    ]),

                Section::make('Logo')
                    ->schema([
                        FileUpload::make('logo')
                            ->image()
                            ->imageEditor()
                            ->directory('sponsors')
                            ->disk('public')
                            ->visibility('public')
                            ->maxSize(2048)
                            ->helperText('Logo image, preferably PNG with transparent background. Max 2MB.'),
                    ]),

                Section::make('Description')
                    ->schema([
                        Textarea::make('description')
                            ->maxLength(1000)
                            ->rows(3),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo')
                    ->circular()
                    ->defaultImageUrl(url('/images/wolf-favicon.png')),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('semibold'),
                TextColumn::make('category')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'title' => 'primary',
                        'gold' => 'warning',
                        'silver' => 'gray',
                        'bronze' => 'amber',
                        default => 'info',
                    }),
                TextColumn::make('website')
                    ->limit(30)
                    ->toggleable(),
                TextColumn::make('sort_order')
                    ->sortable()
                    ->toggleable(),
                IconColumn::make('is_active')
                    ->boolean(),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->options([
                        'title' => 'Title Sponsor',
                        'gold' => 'Gold',
                        'silver' => 'Silver',
                        'bronze' => 'Bronze',
                        'partner' => 'Partner',
                    ]),
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
            'index' => Pages\ListSponsors::route('/'),
            'create' => Pages\CreateSponsor::route('/create'),
            'edit' => Pages\EditSponsor::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'category'];
    }
}
