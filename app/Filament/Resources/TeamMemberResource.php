<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeamMemberResource\Pages;
use App\Models\TeamMember;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Section;
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

class TeamMemberResource extends Resource
{
    protected static ?string $model = TeamMember::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Content';

    protected static ?int $navigationSort = 8;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Member')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(120)
                            ->live(onBlur: true)
                            ->hintIcon('heroicon-m-question-mark-circle')
                            ->hintIconTooltip('Leave the slug blank to auto-generate from the name.'),
                        TextInput::make('slug')
                            ->unique(ignoreRecord: true)
                            ->maxLength(160),
                        TextInput::make('designation')
                            ->required()
                            ->maxLength(120)
                            ->helperText('e.g. Head Coach, Team Manager, Physiotherapist'),
                        TextInput::make('email')
                            ->email()
                            ->maxLength(180),
                        TextInput::make('phone')
                            ->tel()
                            ->maxLength(30),
                        TextInput::make('sort_order')
                            ->numeric()
                            ->default(0)
                            ->helperText('Lower numbers appear first.'),
                        Toggle::make('is_active')
                            ->default(true)
                            ->helperText('Inactive members are hidden from the team page.'),
                    ]),

                Section::make('Photo')
                    ->schema([
                        FileUpload::make('photo')
                            ->image()
                            ->imageEditor()
                            ->directory('team')
                            ->disk('public')
                            ->visibility('public')
                            ->maxSize(4096)
                            ->helperText('Portrait photo, ideally 600×800px. Max 4MB.'),
                    ]),

                Section::make('Biography')
                    ->schema([
                        Textarea::make('bio')
                            ->maxLength(2000)
                            ->rows(4),
                    ]),

                Section::make('Social links')
                    ->collapsed()
                    ->schema([
                        KeyValue::make('social_links')
                            ->keyLabel('Platform')
                            ->valueLabel('URL')
                            ->reorderable(),
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
                TextColumn::make('designation')
                    ->searchable(),
                TextColumn::make('email')
                    ->toggleable()
                    ->copyable(),
                TextColumn::make('sort_order')
                    ->sortable()
                    ->toggleable(),
                IconColumn::make('is_active')
                    ->boolean(),
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
            'index' => Pages\ListTeamMembers::route('/'),
            'create' => Pages\CreateTeamMember::route('/create'),
            'edit' => Pages\EditTeamMember::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'designation'];
    }
}
