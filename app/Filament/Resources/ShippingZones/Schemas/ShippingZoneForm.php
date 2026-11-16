<?php

namespace App\Filament\Resources\ShippingZones\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ShippingZoneForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('code')
                    ->required(),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('country')
                    ->required()
                    ->default('Bangladesh'),
                TextInput::make('division')
                    ->default(null),
                TextInput::make('district')
                    ->default(null),
                Textarea::make('areas')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('shipping_cost')
                    ->required()
                    ->numeric()
                    ->default(0.0)
                    ->prefix('$'),
                TextInput::make('free_shipping_minimum')
                    ->numeric()
                    ->default(null),
                TextInput::make('estimated_min_days')
                    ->required()
                    ->numeric()
                    ->default(1),
                TextInput::make('estimated_max_days')
                    ->required()
                    ->numeric()
                    ->default(3),
                Toggle::make('is_active')
                    ->required(),
                TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
