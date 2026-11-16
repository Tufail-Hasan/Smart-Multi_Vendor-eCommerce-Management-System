<?php

namespace App\Filament\Resources\Shippings\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ShippingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('order_id')
                    ->relationship('order', 'id')
                    ->required(),
                TextInput::make('shipping_number')
                    ->required(),
                TextInput::make('courier_name')
                    ->default(null),
                TextInput::make('tracking_number')
                    ->default(null),
                TextInput::make('shipping_method')
                    ->default(null),
                TextInput::make('shipping_cost')
                    ->required()
                    ->numeric()
                    ->default(0.0)
                    ->prefix('$'),
                Select::make('status')
                    ->options([
            'pending' => 'Pending',
            'ready_to_ship' => 'Ready to ship',
            'shipped' => 'Shipped',
            'in_transit' => 'In transit',
            'out_for_delivery' => 'Out for delivery',
            'delivered' => 'Delivered',
            'failed' => 'Failed',
            'returned' => 'Returned',
            'cancelled' => 'Cancelled',
        ])
                    ->default('pending')
                    ->required(),
                TextInput::make('recipient_name')
                    ->required(),
                TextInput::make('recipient_phone')
                    ->tel()
                    ->required(),
                TextInput::make('recipient_email')
                    ->email()
                    ->default(null),
                TextInput::make('address')
                    ->required(),
                TextInput::make('city')
                    ->required(),
                TextInput::make('state')
                    ->default(null),
                TextInput::make('postal_code')
                    ->default(null),
                TextInput::make('country')
                    ->required()
                    ->default('Bangladesh'),
                DateTimePicker::make('shipped_at'),
                DateTimePicker::make('estimated_delivery_at'),
                DateTimePicker::make('delivered_at'),
                Textarea::make('notes')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('managed_by')
                    ->numeric()
                    ->default(null),
            ]);
    }
}
