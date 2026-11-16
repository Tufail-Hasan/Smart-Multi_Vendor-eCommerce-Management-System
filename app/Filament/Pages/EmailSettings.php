<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Crypt;

class EmailSettings extends Page
{
    protected static string|\BackedEnum|null $navigationIcon =
        'heroicon-o-envelope';

    protected static ?string $navigationLabel = 'Email Settings';

    protected static ?string $title = 'Email Settings';

    protected static string|\UnitEnum|null $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 4;

    protected string $view = 'filament.pages.email-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'mail_enabled' => $this->getBoolean('mail_enabled', false),

            'mail_mailer' => Setting::getValue(
                'mail_mailer',
                'smtp'
            ),

            'mail_host' => Setting::getValue('mail_host', ''),

            'mail_port' => Setting::getValue('mail_port', '587'),

            'mail_username' => Setting::getValue(
                'mail_username',
                ''
            ),

            // Never display a stored SMTP password in the form.
            'mail_password' => '',

            'mail_encryption' => Setting::getValue(
                'mail_encryption',
                'tls'
            ),

            'mail_from_address' => Setting::getValue(
                'mail_from_address',
                ''
            ),

            'mail_from_name' => Setting::getValue(
                'mail_from_name',
                'Smart Store'
            ),

            'admin_notification_email' => Setting::getValue(
                'admin_notification_email',
                ''
            ),
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
                Section::make('Email Service')
                    ->description(
                        'Enable or disable outgoing email and choose the mail driver.'
                    )
                    ->icon('heroicon-o-envelope')
                    ->columns(2)
                    ->schema([
                        Toggle::make('mail_enabled')
                            ->label('Enable Email Sending')
                            ->default(false),

                        Select::make('mail_mailer')
                            ->label('Mail Driver')
                            ->options([
                                'smtp' => 'SMTP',
                                'sendmail' => 'Sendmail',
                                'log' => 'Log (Testing Only)',
                            ])
                            ->required()
                            ->default('smtp')
                            ->live(),
                    ]),

                Section::make('SMTP Configuration')
                    ->description(
                        'Enter the SMTP details supplied by your email provider.'
                    )
                    ->icon('heroicon-o-server')
                    ->columns(2)
                    ->visible(
                        fn ($get): bool =>
                            $get('mail_mailer') === 'smtp'
                    )
                    ->schema([
                        TextInput::make('mail_host')
                            ->label('SMTP Host')
                            ->placeholder('smtp.gmail.com')
                            ->maxLength(255)
                            ->required(
                                fn ($get): bool =>
                                    $get('mail_enabled')
                                    && $get('mail_mailer') === 'smtp'
                            ),

                        TextInput::make('mail_port')
                            ->label('SMTP Port')
                            ->numeric()
                            ->integer()
                            ->minValue(1)
                            ->maxValue(65535)
                            ->default(587)
                            ->required(
                                fn ($get): bool =>
                                    $get('mail_enabled')
                                    && $get('mail_mailer') === 'smtp'
                            ),

                        TextInput::make('mail_username')
                            ->label('SMTP Username')
                            ->email()
                            ->maxLength(255),

                        TextInput::make('mail_password')
                            ->label('SMTP Password')
                            ->password()
                            ->revealable()
                            ->autocomplete('new-password')
                            ->helperText(
                                'Leave blank to keep the previously saved password.'
                            ),

                        Select::make('mail_encryption')
                            ->label('SMTP Encryption')
                            ->options([
                                'tls' => 'TLS / STARTTLS',
                                'ssl' => 'SSL',
                                'none' => 'None',
                            ])
                            ->default('tls')
                            ->required(),
                    ]),

                Section::make('Sender Information')
                    ->description(
                        'Configure the sender address and display name.'
                    )
                    ->icon('heroicon-o-paper-airplane')
                    ->columns(2)
                    ->schema([
                        TextInput::make('mail_from_address')
                            ->label('Sender Email Address')
                            ->email()
                            ->maxLength(255)
                            ->required(
                                fn ($get): bool =>
                                    (bool) $get('mail_enabled')
                            ),

                        TextInput::make('mail_from_name')
                            ->label('Sender Name')
                            ->maxLength(255)
                            ->default('Smart Store')
                            ->required(
                                fn ($get): bool =>
                                    (bool) $get('mail_enabled')
                            ),

                        TextInput::make('admin_notification_email')
                            ->label('Admin Notification Email')
                            ->email()
                            ->maxLength(255)
                            ->helperText(
                                'Email address for administrative notifications.'
                            )
                            ->columnSpanFull(),
                    ]),

                Section::make('Testing Information')
                    ->description(
                        'Use the credentials provided by your email service provider.'
                    )
                    ->icon('heroicon-o-information-circle')
                    ->schema([
                        Placeholder::make('email_help')
                            ->label('Configuration Help')
                            ->content(
                                'For Gmail, use smtp.gmail.com and port 587 with TLS. '
                                . 'A Google App Password may be required. '
                                . 'Do not use your normal Gmail account password.'
                            ),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $settings = [
            'mail_enabled' => [
                'label' => 'Enable Email Sending',
                'value' => !empty($data['mail_enabled']) ? '1' : '0',
                'type' => 'boolean',
                'sensitive' => false,
            ],

            'mail_mailer' => [
                'label' => 'Mail Driver',
                'value' => $data['mail_mailer'] ?? 'smtp',
                'type' => 'text',
                'sensitive' => false,
            ],

            'mail_host' => [
                'label' => 'SMTP Host',
                'value' => $data['mail_host'] ?? '',
                'type' => 'text',
                'sensitive' => false,
            ],

            'mail_port' => [
                'label' => 'SMTP Port',
                'value' => (string) ($data['mail_port'] ?? '587'),
                'type' => 'number',
                'sensitive' => false,
            ],

            'mail_username' => [
                'label' => 'SMTP Username',
                'value' => $data['mail_username'] ?? '',
                'type' => 'email',
                'sensitive' => false,
            ],

            'mail_encryption' => [
                'label' => 'SMTP Encryption',
                'value' => $data['mail_encryption'] ?? 'tls',
                'type' => 'text',
                'sensitive' => false,
            ],

            'mail_from_address' => [
                'label' => 'Sender Email Address',
                'value' => $data['mail_from_address'] ?? '',
                'type' => 'email',
                'sensitive' => false,
            ],

            'mail_from_name' => [
                'label' => 'Sender Name',
                'value' => $data['mail_from_name'] ?? 'Smart Store',
                'type' => 'text',
                'sensitive' => false,
            ],

            'admin_notification_email' => [
                'label' => 'Admin Notification Email',
                'value' => $data['admin_notification_email'] ?? '',
                'type' => 'email',
                'sensitive' => false,
            ],
        ];

        foreach ($settings as $key => $setting) {
            Setting::updateOrCreate(
                ['key' => $key],
                [
                    'group' => 'email',
                    'label' => $setting['label'],
                    'value' => $setting['value'],
                    'type' => $setting['type'],
                    'is_public' => false,
                    'is_sensitive' => $setting['sensitive'],
                    'is_active' => true,
                ]
            );
        }

        // Encrypt the password only if a new password was entered.
        if (filled($data['mail_password'] ?? null)) {
            Setting::updateOrCreate(
                ['key' => 'mail_password'],
                [
                    'group' => 'email',
                    'label' => 'SMTP Password',
                    'value' => Crypt::encryptString(
                        $data['mail_password']
                    ),
                    'type' => 'password',
                    'is_public' => false,
                    'is_sensitive' => true,
                    'is_active' => true,
                ]
            );
        }

        Notification::make()
            ->title('Email Settings Saved')
            ->body(
                'Your email configuration has been saved successfully.'
            )
            ->success()
            ->send();
    }
}
