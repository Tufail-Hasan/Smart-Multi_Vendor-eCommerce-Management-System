<?php

namespace App\Filament\Resources\Payments\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PaymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('order_id')
                    ->relationship('order', 'id')
                    ->required(),
                TextInput::make('payment_number')
                    ->required(),
                TextInput::make('amount')
                    ->required()
                    ->numeric(),
                TextInput::make('currency')
                    ->required()
                    ->default('BDT'),
                Select::make('payment_method')
                    ->options([
            'cash_on_delivery' => 'Cash on delivery',
            'bkash' => 'Bkash',
            'nagad' => 'Nagad',
            'rocket' => 'Rocket',
            'bank_transfer' => 'Bank transfer',
            'card' => 'Card',
            'paypal' => 'Paypal',
            'other' => 'Other',
        ])
                    ->required(),
                Select::make('status')
                    ->options([
            'pending' => 'Pending',
            'processing' => 'Processing',
            'completed' => 'Completed',
            'failed' => 'Failed',
            'cancelled' => 'Cancelled',
            'refunded' => 'Refunded',
            'partially_refunded' => 'Partially refunded',
        ])
                    ->default('pending')
                    ->required(),
                TextInput::make('transaction_id')
                    ->default(null),
                TextInput::make('gateway_name')
                    ->default(null),
                TextInput::make('gateway_reference')
                    ->default(null),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('failure_reason')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('gateway_response')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('refunded_amount')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                DateTimePicker::make('paid_at'),
                DateTimePicker::make('failed_at'),
                DateTimePicker::make('refunded_at'),
                TextInput::make('processed_by')
                    ->numeric()
                    ->default(null),
            ]);
    }
}
