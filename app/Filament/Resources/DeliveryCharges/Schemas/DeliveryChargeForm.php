<?php

namespace App\Filament\Resources\DeliveryCharges\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class DeliveryChargeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('shipping_zone_id')
                    ->relationship('shippingZone', 'name')
                    ->required(),
                Select::make('shipping_method_id')
                    ->relationship('shippingMethod', 'name')
                    ->required(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('code')
                    ->required(),
                TextInput::make('delivery_type')
                    ->required()
                    ->default('standard'),
                TextInput::make('charge')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('additional_charge')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('free_shipping_minimum')
                    ->numeric()
                    ->default(null),
                TextInput::make('included_weight')
                    ->numeric()
                    ->default(null),
                TextInput::make('additional_weight_charge')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('estimated_min_days')
                    ->required()
                    ->numeric()
                    ->default(1),
                TextInput::make('estimated_max_days')
                    ->required()
                    ->numeric()
                    ->default(3),
                TextInput::make('currency')
                    ->required()
                    ->default('BDT'),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                Toggle::make('is_active')
                    ->required(),
                TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
