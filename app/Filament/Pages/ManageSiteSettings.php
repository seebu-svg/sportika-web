<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ManageSiteSettings extends Page
{
    protected static string $view = 'filament.pages.manage-site-settings';

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'Configuration';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Site Settings';

    protected static ?string $title = 'Site Settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(SiteSetting::current()->attributesToArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->statePath('data')
            ->schema([
                Section::make('Brand & hero')
                    ->description('Identity shown across the site header, footer and home page.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('site_name')
                            ->required()
                            ->maxLength(60)
                            ->columnSpan(1),
                        TextInput::make('tagline')
                            ->maxLength(120)
                            ->columnSpan(1),
                        FileUpload::make('logo')
                            ->image()
                            ->imageEditor()
                            ->directory('site')
                            ->disk('public')
                            ->visibility('public')
                            ->maxSize(2048)
                            ->helperText('Site logo, used in the header. Max 2MB.')
                            ->columnSpan(1),
                        FileUpload::make('hero_image')
                            ->image()
                            ->imageEditor()
                            ->directory('site')
                            ->disk('public')
                            ->visibility('public')
                            ->maxSize(4096)
                            ->helperText('Hero banner background, ideally 1920×1080px. Max 4MB.')
                            ->columnSpan(1),
                        TextInput::make('hero_title')
                            ->maxLength(120)
                            ->columnSpan(2),
                        Textarea::make('hero_subtitle')
                            ->maxLength(500)
                            ->rows(2)
                            ->columnSpan(2),
                    ]),

                Section::make('About page')
                    ->schema([
                        TextInput::make('about_title')
                            ->maxLength(120),
                        FileUpload::make('about_image')
                            ->image()
                            ->imageEditor()
                            ->directory('site')
                            ->disk('public')
                            ->visibility('public')
                            ->maxSize(4096)
                            ->helperText('Image shown on the about page or home page intro. Max 4MB.'),
                        RichEditor::make('about_body')
                            ->toolbarButtons(['bold', 'italic', 'h2', 'h3', 'bulletList', 'orderedList', 'link', 'undo', 'redo'])
                            ->columnSpanFull(),
                    ]),

                Section::make('Contact details')
                    ->columns(3)
                    ->schema([
                        TextInput::make('phone')
                            ->tel()
                            ->maxLength(30),
                        TextInput::make('email')
                            ->email()
                            ->maxLength(180),
                        TextInput::make('address')
                            ->maxLength(255),
                    ]),

                Section::make('Social profiles')
                    ->description('Leave a field blank to hide that icon in the footer.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('facebook_url')
                            ->url()
                            ->maxLength(255)
                            ->prefixIcon('heroicon-m-globe-alt'),
                        TextInput::make('twitter_url')
                            ->url()
                            ->maxLength(255),
                        TextInput::make('instagram_url')
                            ->url()
                            ->maxLength(255),
                        TextInput::make('linkedin_url')
                            ->url()
                            ->maxLength(255),
                        TextInput::make('youtube_url')
                            ->url()
                            ->maxLength(255),
                    ]),
            ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        SiteSetting::current()->update($data);

        Notification::make()
            ->success()
            ->title('Settings saved')
            ->body('The public website has been updated.')
            ->send();
    }
}
