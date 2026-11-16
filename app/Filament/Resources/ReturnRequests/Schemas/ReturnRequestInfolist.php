<?php

namespace App\Filament\Resources\ReturnRequests\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ReturnRequestInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('order.id')
                    ->label('Order'),
                TextEntry::make('customer.id')
                    ->label('Customer'),
                TextEntry::make('product.name')
                    ->label('Product'),
                TextEntry::make('return_number'),
                TextEntry::make('quantity')
                    ->numeric(),
                TextEntry::make('reason'),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('item_condition')
                    ->badge()
                    ->placeholder('-'),
                TextEntry::make('refund_amount')
                    ->numeric(),
                TextEntry::make('refund_status')
                    ->badge(),
                TextEntry::make('refund_method')
                    ->placeholder('-'),
                TextEntry::make('refund_transaction_id')
                    ->placeholder('-'),
                TextEntry::make('return_tracking_number')
                    ->placeholder('-'),
                TextEntry::make('return_shipping_cost')
                    ->money(),
                TextEntry::make('reviewed_by')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('admin_note')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('rejection_reason')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('requested_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('approved_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('received_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('refunded_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('completed_at')
                    ->dateTime()
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
