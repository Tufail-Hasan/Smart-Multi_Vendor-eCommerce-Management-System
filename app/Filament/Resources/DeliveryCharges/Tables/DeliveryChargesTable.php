<?php

namespace App\Filament\Resources\DeliveryCharges\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DeliveryChargesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('shippingZone.name')
                    ->searchable(),
                TextColumn::make('shippingMethod.name')
                    ->searchable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('code')
                    ->searchable(),
                TextColumn::make('delivery_type')
                    ->searchable(),
                TextColumn::make('charge')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('additional_charge')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('free_shipping_minimum')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('included_weight')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('additional_weight_charge')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('estimated_min_days')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('estimated_max_days')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('currency')
                    ->searchable(),
                IconColumn::make('is_active')
                    ->boolean(),
                TextColumn::make('sort_order')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
