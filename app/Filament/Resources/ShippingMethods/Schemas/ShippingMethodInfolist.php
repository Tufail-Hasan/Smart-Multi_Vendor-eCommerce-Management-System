<?php

namespace App\Filament\Resources\ShippingMethods\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ShippingMethodInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('code'),
                TextEntry::make('type'),
                TextEntry::make('shipping_cost')
                    ->money(),
                TextEntry::make('free_shipping_minimum')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('estimated_min_days')
                    ->numeric(),
                TextEntry::make('estimated_max_days')
                    ->numeric(),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('logo')
                    ->placeholder('-'),
                TextEntry::make('available_areas')
                    ->placeholder('-')
                    ->columnSpanFull(),
                IconEntry::make('supports_cod')
                    ->boolean(),
                IconEntry::make('is_active')
                    ->boolean(),
                TextEntry::make('sort_order')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
