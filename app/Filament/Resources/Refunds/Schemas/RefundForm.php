<?php

namespace App\Filament\Resources\Refunds\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class RefundForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('order_id')
                    ->relationship('order', 'id')
                    ->required(),
                Select::make('payment_id')
                    ->relationship('payment', 'id')
                    ->default(null),
                Select::make('customer_id')
                    ->relationship('customer', 'id')
                    ->required(),
                TextInput::make('refund_number')
                    ->required(),
                TextInput::make('refund_amount')
                    ->required()
                    ->numeric(),
                TextInput::make('currency')
                    ->required()
                    ->default('BDT'),
                Select::make('refund_type')
                    ->options(['full' => 'Full', 'partial' => 'Partial'])
                    ->default('full')
                    ->required(),
                TextInput::make('reason')
                    ->required(),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                Select::make('refund_method')
                    ->options([
            'original_payment' => 'Original payment',
            'bkash' => 'Bkash',
            'nagad' => 'Nagad',
            'rocket' => 'Rocket',
            'bank_transfer' => 'Bank transfer',
            'cash' => 'Cash',
            'other' => 'Other',
        ])
                    ->default('original_payment')
                    ->required(),
                TextInput::make('refund_account')
                    ->default(null),
                TextInput::make('transaction_id')
                    ->default(null),
                TextInput::make('gateway_reference')
                    ->default(null),
                Select::make('status')
                    ->options([
            'pending' => 'Pending',
            'approved' => 'Approved',
            'processing' => 'Processing',
            'completed' => 'Completed',
            'failed' => 'Failed',
            'rejected' => 'Rejected',
            'cancelled' => 'Cancelled',
        ])
                    ->default('pending')
                    ->required(),
                TextInput::make('processed_by')
                    ->numeric()
                    ->default(null),
                Textarea::make('admin_note')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('failure_reason')
                    ->default(null)
                    ->columnSpanFull(),
                DateTimePicker::make('requested_at'),
                DateTimePicker::make('approved_at'),
                DateTimePicker::make('processed_at'),
                DateTimePicker::make('completed_at'),
                Textarea::make('gateway_response')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
