<?php

namespace App\Filament\Resources\ShippingMethods\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Forms\Components\FileUpload;

class ShippingMethodForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('code')
                    ->required(),
                TextInput::make('type')
                    ->required()
                    ->default('courier'),
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
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                FileUpload::make('logo')
                    ->label('Logo')
                    ->image()
                    ->disk('public')
                    ->directory('shipping-methods')
                    ->imageEditor()
                    ->maxSize(5120)
                    ->nullable(),
                Textarea::make('available_areas')
                    ->default(null)
                    ->columnSpanFull(),
                Toggle::make('supports_cod')
                    ->required(),
                Toggle::make('is_active')
                    ->required(),
                TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
