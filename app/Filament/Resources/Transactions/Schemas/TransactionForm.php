<?php

namespace App\Filament\Resources\Transactions\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class TransactionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('transaction_number')
                    ->required(),
                Select::make('payment_id')
                    ->relationship('payment', 'id')
                    ->default(null),
                Select::make('order_id')
                    ->relationship('order', 'id')
                    ->default(null),
                Select::make('vendor_id')
                    ->relationship('vendor', 'name')
                    ->default(null),
                Select::make('type')
                    ->options([
            'payment' => 'Payment',
            'refund' => 'Refund',
            'payout' => 'Payout',
            'commission' => 'Commission',
            'adjustment' => 'Adjustment',
        ])
                    ->required(),
                TextInput::make('amount')
                    ->required()
                    ->numeric(),
                TextInput::make('currency')
                    ->required()
                    ->default('BDT'),
                TextInput::make('payment_method')
                    ->default(null),
                TextInput::make('gateway_name')
                    ->default(null),
                TextInput::make('gateway_transaction_id')
                    ->default(null),
                TextInput::make('reference_number')
                    ->default(null),
                Select::make('status')
                    ->options([
            'pending' => 'Pending',
            'processing' => 'Processing',
            'completed' => 'Completed',
            'failed' => 'Failed',
            'cancelled' => 'Cancelled',
            'reversed' => 'Reversed',
        ])
                    ->default('pending')
                    ->required(),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('failure_reason')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('gateway_response')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('processed_by')
                    ->numeric()
                    ->default(null),
                DateTimePicker::make('processed_at'),
            ]);
    }
}
