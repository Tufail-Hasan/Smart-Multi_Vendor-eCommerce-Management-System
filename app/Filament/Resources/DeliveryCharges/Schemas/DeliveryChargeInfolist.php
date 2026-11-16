<?php

namespace App\Filament\Resources\DeliveryCharges\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class DeliveryChargeInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('shippingZone.name')
                    ->label('Shipping zone'),
                TextEntry::make('shippingMethod.name')
                    ->label('Shipping method'),
                TextEntry::make('name'),
                TextEntry::make('code'),
                TextEntry::make('delivery_type'),
                TextEntry::make('charge')
                    ->numeric(),
                TextEntry::make('additional_charge')
                    ->numeric(),
                TextEntry::make('free_shipping_minimum')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('included_weight')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('additional_weight_charge')
                    ->numeric(),
                TextEntry::make('estimated_min_days')
                    ->numeric(),
                TextEntry::make('estimated_max_days')
                    ->numeric(),
                TextEntry::make('currency'),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
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
