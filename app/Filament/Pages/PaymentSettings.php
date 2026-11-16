<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification as FilamentNotification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Toggle;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class PaymentSettings extends Page
{
    protected static string|\BackedEnum|null $navigationIcon =
        'heroicon-o-credit-card';

    protected static ?string $navigationLabel = 'Payment Settings';

    protected static ?string $title = 'Payment Settings';

    protected static string|\UnitEnum|null $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 2;

    protected string $view = 'filament.pages.payment-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'currency' => Setting::getValue('payment_currency', 'BDT'),

            'cod_enabled' => $this->getBoolean('cod_enabled'),
            'cod_instructions' => Setting::getValue('cod_instructions', ''),

            'bkash_enabled' => $this->getBoolean('bkash_enabled'),
            'bkash_merchant_number' => Setting::getValue(
                'bkash_merchant_number',
                ''
            ),

            'nagad_enabled' => $this->getBoolean('nagad_enabled'),
            'nagad_merchant_number' => Setting::getValue(
                'nagad_merchant_number',
                ''
            ),

            'rocket_enabled' => $this->getBoolean('rocket_enabled'),
            'rocket_merchant_number' => Setting::getValue(
                'rocket_merchant_number',
                ''
            ),

            'sslcommerz_enabled' => $this->getBoolean('sslcommerz_enabled'),
            'sslcommerz_store_id' => Setting::getValue(
                'sslcommerz_store_id',
                ''
            ),

            'stripe_enabled' => $this->getBoolean('stripe_enabled'),
        ]);
    }

    private function getBoolean(string $key): bool
    {
        return filter_var(
            Setting::getValue($key, '0'),
            FILTER_VALIDATE_BOOLEAN
        );
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('General Payment Configuration')
                    ->description('Configure your store currency and payment preferences.')
                    ->icon('heroicon-o-banknotes')
                    ->columns(2)
                    ->schema([
                        Select::make('currency')
                            ->label('Default Currency')
                            ->options([
                                'BDT' => 'BDT - Bangladeshi Taka',
                                'USD' => 'USD - US Dollar',
                                'EUR' => 'EUR - Euro',
                                'GBP' => 'GBP - British Pound',
                                'INR' => 'INR - Indian Rupee',
                            ])
                            ->required()
                            ->default('BDT'),

                        Toggle::make('cod_enabled')
                            ->label('Enable Cash on Delivery')
                            ->default(true),

                        TextInput::make('cod_instructions')
                            ->label('COD Instructions')
                            ->placeholder('Pay cash when your order arrives.')
                            ->maxLength(500)
                            ->columnSpanFull(),
                    ]),

                Section::make('Mobile Banking')
                    ->description('Enable or disable mobile payment methods.')
                    ->icon('heroicon-o-device-phone-mobile')
                    ->columns(2)
                    ->schema([
                        Toggle::make('bkash_enabled')
                            ->label('Enable bKash')
                            ->default(false),

                        TextInput::make('bkash_merchant_number')
                            ->label('bKash Merchant Number')
                            ->placeholder('Enter merchant number')
                            ->maxLength(100),

                        Toggle::make('nagad_enabled')
                            ->label('Enable Nagad')
                            ->default(false),

                        TextInput::make('nagad_merchant_number')
                            ->label('Nagad Merchant Number')
                            ->placeholder('Enter merchant number')
                            ->maxLength(100),

                        Toggle::make('rocket_enabled')
                            ->label('Enable Rocket')
                            ->default(false),

                        TextInput::make('rocket_merchant_number')
                            ->label('Rocket Merchant Number')
                            ->placeholder('Enter merchant number')
                            ->maxLength(100),
                    ]),

                Section::make('SSLCommerz Configuration')
                    ->description('Configure the SSLCommerz payment gateway.')
                    ->icon('heroicon-o-building-library')
                    ->columns(2)
                    ->schema([
                        Toggle::make('sslcommerz_enabled')
                            ->label('Enable SSLCommerz')
                            ->default(false),

                        TextInput::make('sslcommerz_store_id')
                            ->label('SSLCommerz Store ID')
                            ->maxLength(255),

                        TextInput::make('sslcommerz_store_password')
                            ->label('SSLCommerz Store Password')
                            ->password()
                            ->revealable()
                            ->autocomplete('new-password')
                            ->helperText('Leave blank to keep the previously saved password.')
                            ->dehydrated(),
                    ]),

                Section::make('Stripe Configuration')
                    ->description('Configure Stripe card payments.')
                    ->icon('heroicon-o-credit-card')
                    ->columns(2)
                    ->schema([
                        Toggle::make('stripe_enabled')
                            ->label('Enable Stripe'),

                        TextInput::make('stripe_publishable_key')
                            ->label('Stripe Publishable Key')
                            ->maxLength(255),

                        TextInput::make('stripe_secret_key')
                            ->label('Stripe Secret Key')
                            ->password()
                            ->revealable()
                            ->autocomplete('new-password')
                            ->helperText('Leave blank to keep the previously saved secret key.')
                            ->dehydrated(),

                        TextInput::make('stripe_webhook_secret')
                            ->label('Stripe Webhook Secret')
                            ->password()
                            ->revealable()
                            ->autocomplete('new-password')
                            ->helperText('Leave blank to keep the previously saved webhook secret.')
                            ->dehydrated(),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $settings = [
            'payment_currency' => [
                'value' => $data['currency'] ?? 'BDT',
                'label' => 'Default Currency',
                'type' => 'text',
            ],

            'cod_enabled' => [
                'value' => !empty($data['cod_enabled']) ? '1' : '0',
                'label' => 'Enable Cash on Delivery',
                'type' => 'boolean',
            ],

            'cod_instructions' => [
                'value' => $data['cod_instructions'] ?? '',
                'label' => 'COD Instructions',
                'type' => 'text',
            ],

            'bkash_enabled' => [
                'value' => !empty($data['bkash_enabled']) ? '1' : '0',
                'label' => 'Enable bKash',
                'type' => 'boolean',
            ],

            'bkash_merchant_number' => [
                'value' => $data['bkash_merchant_number'] ?? '',
                'label' => 'bKash Merchant Number',
                'type' => 'text',
            ],

            'nagad_enabled' => [
                'value' => !empty($data['nagad_enabled']) ? '1' : '0',
                'label' => 'Enable Nagad',
                'type' => 'boolean',
            ],

            'nagad_merchant_number' => [
                'value' => $data['nagad_merchant_number'] ?? '',
                'label' => 'Nagad Merchant Number',
                'type' => 'text',
            ],

            'rocket_enabled' => [
                'value' => !empty($data['rocket_enabled']) ? '1' : '0',
                'label' => 'Enable Rocket',
                'type' => 'boolean',
            ],

            'rocket_merchant_number' => [
                'value' => $data['rocket_merchant_number'] ?? '',
                'label' => 'Rocket Merchant Number',
                'type' => 'text',
            ],

            'sslcommerz_enabled' => [
                'value' => !empty($data['sslcommerz_enabled']) ? '1' : '0',
                'label' => 'Enable SSLCommerz',
                'type' => 'boolean',
            ],

            'sslcommerz_store_id' => [
                'value' => $data['sslcommerz_store_id'] ?? '',
                'label' => 'SSLCommerz Store ID',
                'type' => 'text',
            ],

            'stripe_enabled' => [
                'value' => !empty($data['stripe_enabled']) ? '1' : '0',
                'label' => 'Enable Stripe',
                'type' => 'boolean',
            ],

            'stripe_publishable_key' => [
                'value' => $data['stripe_publishable_key'] ?? '',
                'label' => 'Stripe Publishable Key',
                'type' => 'text',
            ],
        ];

        foreach ($settings as $key => $setting) {
            Setting::updateOrCreate(
                ['key' => $key],
                [
                    'group' => 'payment',
                    'label' => $setting['label'],
                    'value' => $setting['value'],
                    'type' => $setting['type'],
                    'is_public' => false,
                    'is_sensitive' => false,
                    'is_active' => true,
                ]
            );
        }

        // Encrypt and save secrets only when a new value is supplied.
        $secrets = [
            'sslcommerz_store_password' => [
                'label' => 'SSLCommerz Store Password',
                'value' => $data['sslcommerz_store_password'] ?? '',
            ],
            'stripe_secret_key' => [
                'label' => 'Stripe Secret Key',
                'value' => $data['stripe_secret_key'] ?? '',
            ],
            'stripe_webhook_secret' => [
                'label' => 'Stripe Webhook Secret',
                'value' => $data['stripe_webhook_secret'] ?? '',
            ],
        ];

        foreach ($secrets as $key => $secret) {
            if (filled($secret['value'])) {
                Setting::updateOrCreate(
                    ['key' => $key],
                    [
                        'group' => 'payment',
                        'label' => $secret['label'],
                        'value' => Crypt::encryptString($secret['value']),
                        'type' => 'password',
                        'is_public' => false,
                        'is_sensitive' => true,
                        'is_active' => true,
                    ]
                );
            }
        }

        FilamentNotification::make()
            ->title('Payment Settings Saved')
            ->body('Your payment preferences have been saved successfully.')
            ->success()
            ->send();
    }
}
