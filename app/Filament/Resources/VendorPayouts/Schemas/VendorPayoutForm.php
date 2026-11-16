<?php

namespace App\Filament\Resources\VendorPayouts\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class VendorPayoutForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                // =========================================================
                // PAYOUT INFORMATION
                // =========================================================
                Section::make('Payout Information')
                    ->description('Basic information about the vendor payout.')
                    ->icon('heroicon-o-banknotes')
                    ->schema([

                        Grid::make(2)
                            ->schema([

                                Select::make('vendor_id')
                                    ->label('Vendor')
                                    ->relationship('vendor', 'name')
                                    //->relationship('vendor', 'store_name')
                                    ->searchable()
                                    ->preload()
                                    ->native(false)
                                    ->required()
                                    ->placeholder('Select vendor'),

                                Select::make('processed_by')
                                    ->label('Processed By')
                                    ->relationship('processor', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->native(false)
                                    ->placeholder('Select admin/user'),

                            ]),

                        Grid::make(3)
                            ->schema([

                                TextInput::make('amount')
                                    ->label('Gross Amount')
                                    ->prefix('৳')
                                    ->numeric()
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                        $amount = (float) ($state ?? 0);
                                        $commission = (float) ($get('commission') ?? 0);

                                        $set(
                                            'net_amount',
                                            number_format(max(0, $amount - $commission), 2, '.', '')
                                        );
                                    })
                                    ->helperText('Total payout before commission.'),

                                TextInput::make('commission')
                                    ->label('Commission')
                                    ->prefix('৳')
                                    ->numeric()
                                    ->default(0)
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                        $amount = (float) ($get('amount') ?? 0);
                                        $commission = (float) ($state ?? 0);

                                        $set(
                                            'net_amount',
                                            number_format(max(0, $amount - $commission), 2, '.', '')
                                        );
                                    })
                                    ->helperText('Platform commission deducted.'),

                                TextInput::make('net_amount')
                                    ->label('Net Payout')
                                    ->prefix('৳')
                                    ->numeric()
                                    ->required()
                                    ->readOnly()
                                    ->dehydrated()
                                    ->extraInputAttributes([
                                        'class' => 'font-bold',
                                    ])
                                    ->helperText('Final amount paid to vendor.'),

                            ]),

                        Grid::make(2)
                            ->schema([

                                Select::make('status')
                                    ->label('Payout Status')
                                    ->options([
                                        'pending' => 'Pending',
                                        'processing' => 'Processing',
                                        'completed' => 'Completed',
                                        'failed' => 'Failed',
                                        'cancelled' => 'Cancelled',
                                    ])
                                    ->default('pending')
                                    ->native(false)
                                    ->required()
                                    ->live(),

                                TextInput::make('reference_number')
                                    ->label('Reference Number')
                                    ->placeholder('e.g. PAY-2026-0001')
                                    ->maxLength(255),

                            ]),

                    ])
                    ->columnSpanFull(),

                // =========================================================
                // PAYMENT INFORMATION
                // =========================================================
                Section::make('Payment Information')
                    ->description('Vendor payment method and account information.')
                    ->icon('heroicon-o-credit-card')
                    ->schema([

                        Grid::make(3)
                            ->schema([

                                Select::make('payment_method')
                                    ->label('Payment Method')
                                    ->options([
                                        'bank' => 'Bank Transfer',
                                        'bkash' => 'bKash',
                                        'nagad' => 'Nagad',
                                        'rocket' => 'Rocket',
                                        'paypal' => 'PayPal',
                                        'stripe' => 'Stripe',
                                        'other' => 'Other',
                                    ])
                                    ->default('bank')
                                    ->native(false)
                                    ->searchable()
                                    ->required()
                                    ->live(),

                                TextInput::make('account_name')
                                    ->label('Account Name')
                                    ->placeholder('Account holder name')
                                    ->maxLength(255),

                                TextInput::make('account_number')
                                    ->label('Account Number')
                                    ->placeholder('Bank / Mobile account number')
                                    ->maxLength(255),

                            ]),

                        Grid::make(2)
                            ->schema([

                                TextInput::make('bank_name')
                                    ->label('Bank Name')
                                    ->placeholder('e.g. Dutch-Bangla Bank')
                                    ->maxLength(255),

                                TextInput::make('branch_name')
                                    ->label('Branch Name')
                                    ->placeholder('e.g. Dhaka Main Branch')
                                    ->maxLength(255),

                            ]),

                    ])
                    ->columnSpanFull(),

                // =========================================================
                // TRANSACTION INFORMATION
                // =========================================================
                Section::make('Transaction Information')
                    ->description('Payment transaction and tracking details.')
                    ->icon('heroicon-o-receipt-percent')
                    ->schema([

                        Grid::make(2)
                            ->schema([

                                TextInput::make('transaction_id')
                                    ->label('Transaction ID')
                                    ->placeholder('Enter transaction ID')
                                    ->maxLength(255),

                                TextInput::make('reference_number')
                                    ->label('Reference Number')
                                    ->placeholder('Internal payout reference')
                                    ->maxLength(255),

                            ]),

                    ])
                    ->columnSpanFull(),

                // =========================================================
                // PAYOUT TIMELINE
                // =========================================================
                Section::make('Payout Timeline')
                    ->description('Track the payout request and processing dates.')
                    ->icon('heroicon-o-clock')
                    ->schema([

                        Grid::make(3)
                            ->schema([

                                DateTimePicker::make('requested_at')
                                    ->label('Requested At')
                                    ->seconds(false)
                                    ->native(false),

                                DateTimePicker::make('processed_at')
                                    ->label('Processed At')
                                    ->seconds(false)
                                    ->native(false),

                                DateTimePicker::make('completed_at')
                                    ->label('Completed At')
                                    ->seconds(false)
                                    ->native(false),

                            ]),

                    ])
                    ->columnSpanFull(),

                // =========================================================
                // NOTES
                // =========================================================
                Section::make('Notes & Remarks')
                    ->description('Additional information regarding this payout.')
                    ->icon('heroicon-o-document-text')
                    ->schema([

                        Textarea::make('note')
                            ->label('Admin Note')
                            ->placeholder('Write any additional note...')
                            ->rows(4)
                            ->maxLength(5000)
                            ->columnSpanFull(),

                        Textarea::make('rejection_reason')
                            ->label('Rejection Reason')
                            ->placeholder('Enter reason if payout is rejected...')
                            ->rows(4)
                            ->maxLength(5000)
                            ->columnSpanFull(),

                    ])
                    ->columnSpanFull(),

            ]);
    }
}
