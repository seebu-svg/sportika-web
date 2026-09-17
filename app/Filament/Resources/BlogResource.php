<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogResource\Pages;
use App\Models\Post;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class BlogResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Content';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationLabel = 'Blog Posts';

    protected static ?string $modelLabel = 'Blog Post';

    protected static ?string $pluralModelLabel = 'Blog Posts';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $slug = 'blog-posts';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('post_type')
                    ->default('blog'),

                Section::make('Article')
                    ->columns(2)
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(180)
                            ->live(onBlur: true)
                            ->hintIcon('heroicon-m-question-mark-circle')
                            ->hintIconTooltip('Leave the slug blank to auto-generate it from the title.'),
                        TextInput::make('slug')
                            ->unique(table: Post::class, ignoreRecord: true)
                            ->maxLength(200),
                        Select::make('category_id')
                            ->label('Tag / Category')
                            ->relationship('category', 'name')
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->required()
                                    ->maxLength(80)
                                    ->live(onBlur: true),
                                TextInput::make('slug')
                                    ->unique(table: 'categories', ignoreRecord: true)
                                    ->maxLength(100),
                            ])
                            ->native(false)
                            ->placeholder('No tag'),
                        Select::make('author_id')
                            ->label('Author')
                            ->relationship('author', 'name')
                            ->default(Auth::id())
                            ->native(false)
                            ->required(),
                        DatePicker::make('published_at')
                            ->label('Publish date')
                            ->native(false)
                            ->displayFormat('d M Y')
                            ->default(now())
                            ->helperText('Future dates will schedule the post — it stays hidden until then.'),
                        Toggle::make('is_featured')
                            ->helperText('Featured blog posts are highlighted on the blogs page.'),
                    ]),

                Section::make('Cover & summary')
                    ->columns(2)
                    ->schema([
                        FileUpload::make('cover_image')
                            ->image()
                            ->imageEditor()
                            ->directory('blogs')
                            ->disk('public')
                            ->visibility('public')
                            ->maxSize(4096)
                            ->helperText('Wide cover image, ideally 1600×900px. Max 4MB.'),
                        Textarea::make('excerpt')
                            ->maxLength(500)
                            ->rows(4)
                            ->columnSpan(1)
                            ->helperText('Short summary shown on cards. Written automatically if left blank.'),
                    ]),

                Section::make('Content')
                    ->schema([
                        RichEditor::make('content')
                            ->required()
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsDirectory('blogs/attachments')
                            ->fileAttachmentsVisibility('public')
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'strike',
                                'h2',
                                'h3',
                                'link',
                                'blockquote',
                                'bulletList',
                                'orderedList',
                                'table',
                                'codeBlock',
                                'undo',
                                'redo',
                            ])
                            ->columnSpanFull(),
                    ]),

                Section::make('SEO')
                    ->collapsed()
                    ->columns(2)
                    ->schema([
                        TextInput::make('meta_title')
                            ->maxLength(70)
                            ->helperText('Defaults to the article title.'),
                        Textarea::make('meta_description')
                            ->maxLength(160)
                            ->rows(2)
                            ->columnSpan(1),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->where('post_type', 'blog'))
            ->columns([
                ImageColumn::make('cover_image')
                    ->rounded()
                    ->defaultImageUrl(url('/images/post-fallback.svg')),
                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->weight('semibold')
                    ->limit(50),
                TextColumn::make('category.name')
                    ->label('Tag')
                    ->badge()
                    ->placeholder('—'),
                TextColumn::make('author.name')
                    ->toggleable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'published' ? 'success' : 'gray'),
                TextColumn::make('published_at')
                    ->label('Publish date')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(),
                IconColumn::make('is_featured')
                    ->boolean()
                    ->label('Featured')
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(Post::STATUSES),
                SelectFilter::make('category')
                    ->label('Tag')
                    ->relationship('category', 'name'),
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

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBlogs::route('/'),
            'create' => Pages\CreateBlog::route('/create'),
            'edit' => Pages\EditBlog::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['title'];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('post_type', 'blog');
    }
}
