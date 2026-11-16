<?php

namespace App\Filament\Resources\ReturnRequests\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ReturnRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('order_id')
                    ->relationship('order', 'id')
                    ->required(),
                Select::make('customer_id')
                    ->relationship('customer', 'id')
                    ->required(),
                Select::make('product_id')
                    ->relationship('product', 'name')
                    ->required(),
                TextInput::make('return_number')
                    ->required(),
                TextInput::make('quantity')
                    ->required()
                    ->numeric()
                    ->default(1),
                TextInput::make('reason')
                    ->required(),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                Select::make('status')
                    ->options([
            'pending' => 'Pending',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
            'item_shipped' => 'Item shipped',
            'item_received' => 'Item received',
            'inspecting' => 'Inspecting',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
        ])
                    ->default('pending')
                    ->required(),
                Select::make('item_condition')
                    ->options([
            'unopened' => 'Unopened',
            'unused' => 'Unused',
            'used' => 'Used',
            'damaged' => 'Damaged',
            'defective' => 'Defective',
        ])
                    ->default(null),
                TextInput::make('refund_amount')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                Select::make('refund_status')
                    ->options([
            'pending' => 'Pending',
            'approved' => 'Approved',
            'processing' => 'Processing',
            'completed' => 'Completed',
            'rejected' => 'Rejected',
        ])
                    ->default('pending')
                    ->required(),
                TextInput::make('refund_method')
                    ->default(null),
                TextInput::make('refund_transaction_id')
                    ->default(null),
                TextInput::make('return_tracking_number')
                    ->default(null),
                TextInput::make('return_shipping_cost')
                    ->required()
                    ->numeric()
                    ->default(0.0)
                    ->prefix('$'),
                TextInput::make('reviewed_by')
                    ->numeric()
                    ->default(null),
                Textarea::make('admin_note')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('rejection_reason')
                    ->default(null)
                    ->columnSpanFull(),
                DateTimePicker::make('requested_at'),
                DateTimePicker::make('approved_at'),
                DateTimePicker::make('received_at'),
                DateTimePicker::make('refunded_at'),
                DateTimePicker::make('completed_at'),
            ]);
    }
}
