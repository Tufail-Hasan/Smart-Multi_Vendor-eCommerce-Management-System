<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ShippingSettings extends Page
{
    protected static string|\BackedEnum|null $navigationIcon =
        'heroicon-o-truck';

    protected static ?string $navigationLabel = 'Shipping Settings';

    protected static ?string $title = 'Shipping Settings';

    protected static string|\UnitEnum|null $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 3;

    protected string $view = 'filament.pages.shipping-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'shipping_enabled' => $this->getBoolean(
                'shipping_enabled',
                true
            ),

            'default_shipping_charge' => Setting::getValue(
                'default_shipping_charge',
                '80'
            ),

            'free_shipping_enabled' => $this->getBoolean(
                'free_shipping_enabled',
                true
            ),

            'free_shipping_minimum' => Setting::getValue(
                'free_shipping_minimum',
                '2000'
            ),

            'cod_shipping_charge' => Setting::getValue(
                'cod_shipping_charge',
                '100'
            ),

            'estimated_min_days' => Setting::getValue(
                'estimated_min_days',
                '2'
            ),

            'estimated_max_days' => Setting::getValue(
                'estimated_max_days',
                '5'
            ),

            'shipping_country' => Setting::getValue(
                'shipping_country',
                'Bangladesh'
            ),

            'weight_unit' => Setting::getValue(
                'weight_unit',
                'kg'
            ),

            'shipping_instructions' => Setting::getValue(
                'shipping_instructions',
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
                Section::make('Shipping Configuration')
                    ->description(
                        'Enable or disable shipping and configure the default delivery charge.'
                    )
                    ->icon('heroicon-o-truck')
                    ->columns(2)
                    ->schema([
                        Toggle::make('shipping_enabled')
                            ->label('Enable Shipping')
                            ->default(true)
                            ->required(),

                        TextInput::make('default_shipping_charge')
                            ->label('Default Shipping Charge (৳)')
                            ->numeric()
                            ->minValue(0)
                            ->required()
                            ->default(80)
                            ->prefix('৳'),

                        Toggle::make('free_shipping_enabled')
                            ->label('Enable Free Shipping')
                            ->default(true)
                            ->live(),

                        TextInput::make('free_shipping_minimum')
                            ->label('Free Shipping Minimum Amount (৳)')
                            ->numeric()
                            ->minValue(0)
                            ->required()
                            ->default(2000)
                            ->prefix('৳')
                            ->visible(
                                fn ($get): bool =>
                                    (bool) $get('free_shipping_enabled')
                            ),

                        TextInput::make('cod_shipping_charge')
                            ->label('Cash on Delivery Shipping Charge (৳)')
                            ->numeric()
                            ->minValue(0)
                            ->required()
                            ->default(100)
                            ->prefix('৳'),
                    ]),

                Section::make('Delivery Time')
                    ->description(
                        'Set the estimated delivery time for customers.'
                    )
                    ->icon('heroicon-o-clock')
                    ->columns(2)
                    ->schema([
                        TextInput::make('estimated_min_days')
                            ->label('Minimum Delivery Days')
                            ->numeric()
                            ->integer()
                            ->minValue(1)
                            ->required()
                            ->default(2)
                            ->suffix('days'),

                        TextInput::make('estimated_max_days')
                            ->label('Maximum Delivery Days')
                            ->numeric()
                            ->integer()
                            ->minValue(1)
                            ->required()
                            ->default(5)
                            ->suffix('days')
                            ->rules([
                                fn ($get): string =>
                                    'gte:' . (int) ($get('estimated_min_days') ?? 1),
                            ]),
                    ]),

                Section::make('Shipping Preferences')
                    ->description(
                        'Configure the default destination country and product weight unit.'
                    )
                    ->icon('heroicon-o-globe-alt')
                    ->columns(2)
                    ->schema([
                        Select::make('shipping_country')
                            ->label('Default Shipping Country')
                            ->options([
                                'Bangladesh' => 'Bangladesh',
                                'India' => 'India',
                                'Pakistan' => 'Pakistan',
                                'United States' => 'United States',
                                'United Kingdom' => 'United Kingdom',
                            ])
                            ->required()
                            ->default('Bangladesh')
                            ->searchable(),

                        Select::make('weight_unit')
                            ->label('Product Weight Unit')
                            ->options([
                                'kg' => 'Kilogram (kg)',
                                'g' => 'Gram (g)',
                                'lb' => 'Pound (lb)',
                            ])
                            ->required()
                            ->default('kg'),

                        Textarea::make('shipping_instructions')
                            ->label('Shipping Instructions')
                            ->placeholder(
                                'Example: Delivery may take longer in remote areas.'
                            )
                            ->rows(4)
                            ->maxLength(2000)
                            ->columnSpanFull(),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $minimumDays = (int) ($data['estimated_min_days'] ?? 1);
        $maximumDays = (int) ($data['estimated_max_days'] ?? 1);

        if ($maximumDays < $minimumDays) {
            Notification::make()
                ->title('Invalid Delivery Time')
                ->body(
                    'Maximum delivery days must be greater than or equal to minimum delivery days.'
                )
                ->danger()
                ->send();

            return;
        }

        $settings = [
            'shipping_enabled' => [
                'label' => 'Enable Shipping',
                'value' => !empty($data['shipping_enabled']) ? '1' : '0',
                'type' => 'boolean',
            ],

            'default_shipping_charge' => [
                'label' => 'Default Shipping Charge',
                'value' => (string) ($data['default_shipping_charge'] ?? '80'),
                'type' => 'number',
            ],

            'free_shipping_enabled' => [
                'label' => 'Enable Free Shipping',
                'value' => !empty($data['free_shipping_enabled']) ? '1' : '0',
                'type' => 'boolean',
            ],

            'free_shipping_minimum' => [
                'label' => 'Free Shipping Minimum Amount',
                'value' => (string) ($data['free_shipping_minimum'] ?? '2000'),
                'type' => 'number',
            ],

            'cod_shipping_charge' => [
                'label' => 'Cash on Delivery Shipping Charge',
                'value' => (string) ($data['cod_shipping_charge'] ?? '100'),
                'type' => 'number',
            ],

            'estimated_min_days' => [
                'label' => 'Minimum Delivery Days',
                'value' => (string) $minimumDays,
                'type' => 'number',
            ],

            'estimated_max_days' => [
                'label' => 'Maximum Delivery Days',
                'value' => (string) $maximumDays,
                'type' => 'number',
            ],

            'shipping_country' => [
                'label' => 'Default Shipping Country',
                'value' => $data['shipping_country'] ?? 'Bangladesh',
                'type' => 'text',
            ],

            'weight_unit' => [
                'label' => 'Product Weight Unit',
                'value' => $data['weight_unit'] ?? 'kg',
                'type' => 'text',
            ],

            'shipping_instructions' => [
                'label' => 'Shipping Instructions',
                'value' => $data['shipping_instructions'] ?? '',
                'type' => 'textarea',
            ],
        ];

        foreach ($settings as $key => $setting) {
            Setting::updateOrCreate(
                ['key' => $key],
                [
                    'group' => 'shipping',
                    'label' => $setting['label'],
                    'value' => $setting['value'],
                    'type' => $setting['type'],
                    'is_public' => true,
                    'is_sensitive' => false,
                    'is_active' => true,
                ]
            );
        }

        Notification::make()
            ->title('Shipping Settings Saved')
            ->body('Your shipping configuration has been updated successfully.')
            ->success()
            ->send();
    }
}
