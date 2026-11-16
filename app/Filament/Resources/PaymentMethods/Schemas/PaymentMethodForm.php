<?php

namespace App\Filament\Resources\PaymentMethods\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\KeyValue;

class PaymentMethodForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('code')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                FileUpload::make('logo')
                    ->label('Payment Method Logo')
                    ->image()
                    ->disk('public')
                    ->directory('payment-methods')
                    ->visibility('public')
                    ->imageEditor()
                    ->maxSize(2048),
                Select::make('type')
                    ->options(['manual' => 'Manual', 'gateway' => 'Gateway'])
                    ->default('gateway')
                    ->required(),
                Select::make('method_type')
                    ->options([
                        'cash_on_delivery' => 'Cash on delivery',
                        'mobile_banking' => 'Mobile banking',
                        'bank_transfer' => 'Bank transfer',
                        'card' => 'Card',
                        'digital_wallet' => 'Digital wallet',
                        'other' => 'Other',
                    ])
                    ->default('other')
                    ->required(),
                TextInput::make('gateway_name')
                    ->default(null),
                KeyValue::make('configuration')
                    ->label('Gateway Configuration')
                    ->keyLabel('Setting Name')
                    ->valueLabel('Setting Value')
                    ->addActionLabel('Add Configuration')
                    ->reorderable()
                    ->columnSpanFull(),
                TextInput::make('fixed_fee')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('percentage_fee')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('minimum_amount')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('maximum_amount')
                    ->numeric()
                    ->default(null),
                TextInput::make('currency')
                    ->required()
                    ->default('BDT'),
                Toggle::make('is_active')
                    ->required(),
                Toggle::make('is_test_mode')
                    ->required(),
                Toggle::make('supports_refund')
                    ->required(),
                TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('created_by')
                    ->numeric()
                    ->default(null),
            ]);
    }
}
