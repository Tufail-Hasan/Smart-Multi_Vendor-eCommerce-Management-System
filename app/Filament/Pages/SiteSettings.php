<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SiteSettings extends Page
{
    protected static string|\BackedEnum|null $navigationIcon =
        'heroicon-o-globe-alt';

    protected static ?string $navigationLabel = 'Site Settings';

    protected static ?string $title = 'Site Settings';

    protected static string|\UnitEnum|null $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 5;

    protected string $view = 'filament.pages.site-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'meta_title' => Setting::getValue(
                'meta_title',
                'Smart Multi-Vendor Store'
            ),

            'meta_description' => Setting::getValue(
                'meta_description',
                'Shop quality products from trusted vendors.'
            ),

            'meta_keywords' => Setting::getValue(
                'meta_keywords',
                'online shopping, ecommerce, marketplace'
            ),

            'meta_author' => Setting::getValue(
                'meta_author',
                'Smart Store'
            ),

            'favicon' => Setting::getValue('favicon', ''),

            'google_analytics_id' => Setting::getValue(
                'google_analytics_id',
                ''
            ),

            'search_engine_indexing' => $this->getBoolean(
                'search_engine_indexing',
                true
            ),

            'maintenance_mode' => $this->getBoolean(
                'maintenance_mode',
                false
            ),

            'maintenance_message' => Setting::getValue(
                'maintenance_message',
                'Our website is currently under maintenance. Please visit again soon.'
            ),

            'facebook_url' => Setting::getValue('facebook_url', ''),
            'instagram_url' => Setting::getValue('instagram_url', ''),
            'youtube_url' => Setting::getValue('youtube_url', ''),
            'linkedin_url' => Setting::getValue('linkedin_url', ''),
        ]);
    }

    private function getBoolean(
        string $key,
        bool $default = false
    ): bool {
        return filter_var(
            Setting::getValue($key, $default ? '1' : '0'),
            FILTER_VALIDATE_BOOLEAN
        );
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('SEO Configuration')
                    ->description(
                        'Configure the metadata displayed to search engines.'
                    )
                    ->icon('heroicon-o-magnifying-glass')
                    ->columns(2)
                    ->schema([
                        TextInput::make('meta_title')
                            ->label('Meta Title')
                            ->required()
                            ->maxLength(255)
                            ->helperText(
                                'Recommended: around 50–60 characters.'
                            ),

                        TextInput::make('meta_author')
                            ->label('Meta Author')
                            ->maxLength(255),

                        Textarea::make('meta_description')
                            ->label('Meta Description')
                            ->rows(3)
                            ->maxLength(500)
                            ->helperText(
                                'Write a concise description of your website.'
                            )
                            ->columnSpanFull(),

                        Textarea::make('meta_keywords')
                            ->label('Meta Keywords')
                            ->rows(2)
                            ->maxLength(1000)
                            ->helperText(
                                'Separate keywords with commas.'
                            )
                            ->columnSpanFull(),

                        Toggle::make('search_engine_indexing')
                            ->label('Allow Search Engine Indexing')
                            ->default(true)
                            ->helperText(
                                'This setting must be connected to your website metadata or robots rules to take effect.'
                            )
                            ->columnSpanFull(),
                    ]),

                Section::make('Website Favicon')
                    ->description(
                        'Upload the small icon displayed in browser tabs.'
                    )
                    ->icon('heroicon-o-photo')
                    ->schema([
                        FileUpload::make('favicon')
                            ->label('Favicon')
                            ->image()
                            ->disk('public')
                            ->directory('settings/favicon')
                            ->visibility('public')
                            ->maxSize(1024)
                            ->helperText(
                                'Upload a square PNG, ICO or supported image. Recommended size: 32 × 32 or 48 × 48 pixels.'
                            ),
                    ]),

                Section::make('Google Analytics')
                    ->description(
                        'Connect your website to Google Analytics.'
                    )
                    ->icon('heroicon-o-chart-bar')
                    ->schema([
                        TextInput::make('google_analytics_id')
                            ->label('Google Analytics Measurement ID')
                            ->placeholder('G-XXXXXXXXXX')
                            ->maxLength(100)
                            ->helperText(
                                'Example: G-XXXXXXXXXX. This ID must be integrated into your website layout.'
                            ),
                    ]),

                Section::make('Maintenance Mode')
                    ->description(
                        'Configure the maintenance status and message.'
                    )
                    ->icon('heroicon-o-wrench-screwdriver')
                    ->schema([
                        Toggle::make('maintenance_mode')
                            ->label('Enable Maintenance Mode')
                            ->default(false)
                            ->live()
                            ->helperText(
                                'Saving this option does not automatically enable Laravel maintenance mode.'
                            ),

                        Textarea::make('maintenance_message')
                            ->label('Maintenance Message')
                            ->rows(3)
                            ->maxLength(1000)
                            ->visible(
                                fn ($get): bool =>
                                    (bool) $get('maintenance_mode')
                            )
                            ->columnSpanFull(),
                    ]),

                Section::make('Social Media Links')
                    ->description(
                        'Add your official social media profile URLs.'
                    )
                    ->icon('heroicon-o-share')
                    ->columns(2)
                    ->schema([
                        TextInput::make('facebook_url')
                            ->label('Facebook URL')
                            ->url()
                            ->maxLength(255)
                            ->placeholder('https://www.facebook.com/yourpage'),

                        TextInput::make('instagram_url')
                            ->label('Instagram URL')
                            ->url()
                            ->maxLength(255)
                            ->placeholder('https://www.instagram.com/yourprofile'),

                        TextInput::make('youtube_url')
                            ->label('YouTube URL')
                            ->url()
                            ->maxLength(255)
                            ->placeholder('https://www.youtube.com/@yourchannel'),

                        TextInput::make('linkedin_url')
                            ->label('LinkedIn URL')
                            ->url()
                            ->maxLength(255)
                            ->placeholder('https://www.linkedin.com/company/yourcompany'),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $settings = [
            'meta_title' => [
                'label' => 'Meta Title',
                'value' => $data['meta_title'] ?? '',
                'type' => 'text',
                'public' => true,
            ],

            'meta_description' => [
                'label' => 'Meta Description',
                'value' => $data['meta_description'] ?? '',
                'type' => 'textarea',
                'public' => true,
            ],

            'meta_keywords' => [
                'label' => 'Meta Keywords',
                'value' => $data['meta_keywords'] ?? '',
                'type' => 'textarea',
                'public' => true,
            ],

            'meta_author' => [
                'label' => 'Meta Author',
                'value' => $data['meta_author'] ?? '',
                'type' => 'text',
                'public' => true,
            ],

            'favicon' => [
                'label' => 'Favicon',
                'value' => $data['favicon'] ?? '',
                'type' => 'image',
                'public' => true,
            ],

            'google_analytics_id' => [
                'label' => 'Google Analytics Measurement ID',
                'value' => $data['google_analytics_id'] ?? '',
                'type' => 'text',
                'public' => false,
            ],

            'search_engine_indexing' => [
                'label' => 'Allow Search Engine Indexing',
                'value' => !empty($data['search_engine_indexing'])
                    ? '1'
                    : '0',
                'type' => 'boolean',
                'public' => true,
            ],

            'maintenance_mode' => [
                'label' => 'Enable Maintenance Mode',
                'value' => !empty($data['maintenance_mode'])
                    ? '1'
                    : '0',
                'type' => 'boolean',
                'public' => false,
            ],

            'maintenance_message' => [
                'label' => 'Maintenance Message',
                'value' => $data['maintenance_message'] ?? '',
                'type' => 'textarea',
                'public' => true,
            ],

            'facebook_url' => [
                'label' => 'Facebook URL',
                'value' => $data['facebook_url'] ?? '',
                'type' => 'url',
                'public' => true,
            ],

            'instagram_url' => [
                'label' => 'Instagram URL',
                'value' => $data['instagram_url'] ?? '',
                'type' => 'url',
                'public' => true,
            ],

            'youtube_url' => [
                'label' => 'YouTube URL',
                'value' => $data['youtube_url'] ?? '',
                'type' => 'url',
                'public' => true,
            ],

            'linkedin_url' => [
                'label' => 'LinkedIn URL',
                'value' => $data['linkedin_url'] ?? '',
                'type' => 'url',
                'public' => true,
            ],
        ];

        foreach ($settings as $key => $setting) {
            Setting::updateOrCreate(
                ['key' => $key],
                [
                    'group' => 'site',
                    'label' => $setting['label'],
                    'value' => $setting['value'],
                    'type' => $setting['type'],
                    'is_public' => $setting['public'],
                    'is_sensitive' => false,
                    'is_active' => true,
                ]
            );
        }

        Notification::make()
            ->title('Site Settings Saved')
            ->body(
                'Your website SEO and site preferences have been saved successfully.'
            )
            ->success()
            ->send();
    }
}
