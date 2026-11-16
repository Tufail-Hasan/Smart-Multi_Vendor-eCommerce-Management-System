<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('order_number')
                    ->required(),
                Select::make('customer_id')
                    ->relationship('customer', 'id')
                    ->required(),
                TextInput::make('subtotal')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('discount_amount')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('shipping_charge')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('tax_amount')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('total_amount')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('payment_method')
                    ->default(null),
                Select::make('payment_status')
                    ->options([
            'pending' => 'Pending',
            'paid' => 'Paid',
            'failed' => 'Failed',
            'refunded' => 'Refunded',
            'partially_refunded' => 'Partially refunded',
        ])
                    ->default('pending')
                    ->required(),
                TextInput::make('transaction_id')
                    ->default(null),
                Select::make('status')
                    ->options([
            'pending' => 'Pending',
            'confirmed' => 'Confirmed',
            'processing' => 'Processing',
            'shipped' => 'Shipped',
            'delivered' => 'Delivered',
            'cancelled' => 'Cancelled',
            'returned' => 'Returned',
        ])
                    ->default('pending')
                    ->required(),
                TextInput::make('shipping_name')
                    ->required(),
                TextInput::make('shipping_phone')
                    ->tel()
                    ->required(),
                TextInput::make('shipping_email')
                    ->email()
                    ->default(null),
                TextInput::make('shipping_address')
                    ->required(),
                TextInput::make('shipping_city')
                    ->required(),
                TextInput::make('shipping_state')
                    ->default(null),
                TextInput::make('shipping_postal_code')
                    ->default(null),
                TextInput::make('shipping_country')
                    ->required()
                    ->default('Bangladesh'),
                TextInput::make('billing_name')
                    ->default(null),
                TextInput::make('billing_phone')
                    ->tel()
                    ->default(null),
                TextInput::make('billing_address')
                    ->default(null),
                TextInput::make('billing_city')
                    ->default(null),
                Textarea::make('customer_note')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('admin_note')
                    ->default(null)
                    ->columnSpanFull(),
                DateTimePicker::make('placed_at'),
                DateTimePicker::make('shipped_at'),
                DateTimePicker::make('delivered_at'),
                DateTimePicker::make('cancelled_at'),
            ]);
    }
}
