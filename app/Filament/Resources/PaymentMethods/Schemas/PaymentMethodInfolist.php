<?php

namespace App\Filament\Resources\PaymentMethods\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PaymentMethodInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('code'),
                TextEntry::make('slug'),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('logo')
                    ->placeholder('-'),
                TextEntry::make('type')
                    ->badge(),
                TextEntry::make('method_type')
                    ->badge(),
                TextEntry::make('gateway_name')
                    ->placeholder('-'),
                TextEntry::make('configuration')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('fixed_fee')
                    ->numeric(),
                TextEntry::make('percentage_fee')
                    ->numeric(),
                TextEntry::make('minimum_amount')
                    ->numeric(),
                TextEntry::make('maximum_amount')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('currency'),
                IconEntry::make('is_active')
                    ->boolean(),
                IconEntry::make('is_test_mode')
                    ->boolean(),
                IconEntry::make('supports_refund')
                    ->boolean(),
                TextEntry::make('sort_order')
                    ->numeric(),
                TextEntry::make('created_by')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
