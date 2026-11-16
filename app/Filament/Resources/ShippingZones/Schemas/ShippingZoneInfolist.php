<?php

namespace App\Filament\Resources\ShippingZones\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ShippingZoneInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('code'),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('country'),
                TextEntry::make('division')
                    ->placeholder('-'),
                TextEntry::make('district')
                    ->placeholder('-'),
                TextEntry::make('areas')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('shipping_cost')
                    ->money(),
                TextEntry::make('free_shipping_minimum')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('estimated_min_days')
                    ->numeric(),
                TextEntry::make('estimated_max_days')
                    ->numeric(),
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
