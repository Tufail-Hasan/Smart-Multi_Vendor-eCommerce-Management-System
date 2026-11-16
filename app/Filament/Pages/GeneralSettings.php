<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class GeneralSettings extends Page
{
    protected static string|\BackedEnum|null $navigationIcon =
        'heroicon-o-cog-6-tooth';

    protected static ?string $navigationLabel = 'General Settings';

    protected static ?string $title = 'General Settings';

    protected static string|\UnitEnum|null $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 1;

    protected string $view = 'filament.pages.general-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'site_name' => Setting::getValue('site_name', 'Smart Store'),
            'tagline' => Setting::getValue('tagline', ''),
            'support_email' => Setting::getValue('support_email', ''),
            'phone' => Setting::getValue('phone', ''),
            'address' => Setting::getValue('address', ''),
            'currency' => Setting::getValue('currency', 'BDT'),
            'timezone' => Setting::getValue('timezone', 'Asia/Dhaka'),
            'site_logo' => Setting::getValue('site_logo', ''),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Website Information')
                    ->description('Manage your store information.')
                    ->icon('heroicon-o-building-storefront')
                    ->columns(2)
                    ->schema([
                        TextInput::make('site_name')
                            ->label('Site Name')
                            ->required()
                            ->maxLength(150),

                        TextInput::make('tagline')
                            ->label('Tagline')
                            ->maxLength(255),

                        TextInput::make('support_email')
                            ->label('Support Email')
                            ->email(),

                        TextInput::make('phone')
                            ->label('Phone Number')
                            ->tel(),

                        TextInput::make('currency')
                            ->label('Currency')
                            ->required()
                            ->default('BDT')
                            ->maxLength(10),

                        TextInput::make('timezone')
                            ->label('Timezone')
                            ->required()
                            ->default('Asia/Dhaka')
                            ->maxLength(100),

                        Textarea::make('address')
                            ->label('Business Address')
                            ->rows(3)
                            ->columnSpanFull(),

                        FileUpload::make('site_logo')
                            ->label('Website Logo')
                            ->image()
                            ->disk('public')
                            ->directory('settings')
                            ->visibility('public')
                            ->imageEditor()
                            ->maxSize(2048)
                            ->columnSpanFull(),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $settings = [
            'site_name' => [
                'label' => 'Site Name',
                'value' => $data['site_name'] ?? '',
                'type' => 'text',
            ],
            'tagline' => [
                'label' => 'Tagline',
                'value' => $data['tagline'] ?? '',
                'type' => 'text',
            ],
            'support_email' => [
                'label' => 'Support Email',
                'value' => $data['support_email'] ?? '',
                'type' => 'email',
            ],
            'phone' => [
                'label' => 'Phone Number',
                'value' => $data['phone'] ?? '',
                'type' => 'text',
            ],
            'address' => [
                'label' => 'Business Address',
                'value' => $data['address'] ?? '',
                'type' => 'textarea',
            ],
            'currency' => [
                'label' => 'Currency',
                'value' => $data['currency'] ?? 'BDT',
                'type' => 'text',
            ],
            'timezone' => [
                'label' => 'Timezone',
                'value' => $data['timezone'] ?? 'Asia/Dhaka',
                'type' => 'text',
            ],
            'site_logo' => [
                'label' => 'Website Logo',
                'value' => $data['site_logo'] ?? '',
                'type' => 'image',
            ],
        ];

        foreach ($settings as $key => $setting) {
            Setting::setValue(
                $key,
                $setting['value'],
                'general',
                $setting['label'],
                $setting['type']
            );
        }

        Notification::make()
            ->title('General Settings Saved')
            ->body('Your website settings have been updated successfully.')
            ->success()
            ->send();
    }
}
