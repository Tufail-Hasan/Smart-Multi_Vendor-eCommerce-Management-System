<?php

namespace App\Filament\Resources\VendorPayouts\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class VendorPayoutInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                // =========================================================
                // PAYOUT SUMMARY
                // =========================================================
                Section::make('Payout Summary')
                    ->description('Overview of this vendor payout.')
                    ->icon('heroicon-o-banknotes')
                    ->schema([

                        Grid::make(4)
                            ->schema([

                                TextEntry::make('vendor.name')
                                    ->label('Vendor')
                                    ->icon('heroicon-o-building-storefront')
                                    ->weight('bold')
                                    ->placeholder('-'),

                                TextEntry::make('amount')
                                    ->label('Gross Amount')
                                    ->money('BDT')
                                    ->weight('bold')
                                    ->placeholder('-'),

                                TextEntry::make('commission')
                                    ->label('Commission')
                                    ->money('BDT')
                                    ->placeholder('-'),

                                TextEntry::make('net_amount')
                                    ->label('Net Payout')
                                    ->money('BDT')
                                    ->weight('bold')
                                    ->placeholder('-'),

                            ]),

                        Grid::make(3)
                            ->schema([

                                TextEntry::make('status')
                                    ->label('Status')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'pending' => 'warning',
                                        'processing' => 'info',
                                        'completed' => 'success',
                                        'failed' => 'danger',
                                        'cancelled' => 'gray',
                                        default => 'gray',
                                    })
                                    ->formatStateUsing(
                                        fn (string $state): string => str($state)->headline()
                                    ),

                                TextEntry::make('payment_method')
                                    ->label('Payment Method')
                                    ->badge()
                                    ->color('primary')
                                    ->formatStateUsing(
                                        fn (string $state): string => match ($state) {
                                            'bank' => 'Bank Transfer',
                                            'bkash' => 'bKash',
                                            'nagad' => 'Nagad',
                                            'rocket' => 'Rocket',
                                            'paypal' => 'PayPal',
                                            'stripe' => 'Stripe',
                                            'other' => 'Other',
                                            default => str($state)->headline(),
                                        }
                                    ),

                                TextEntry::make('processed_by')
                                    ->label('Processed By')
                                    ->formatStateUsing(
                                        fn ($state, $record) =>
                                            $record->processor?->name ?? '-'
                                    )
                                    ->icon('heroicon-o-user'),

                            ]),

                    ])
                    ->columnSpanFull(),

                // =========================================================
                // PAYMENT DETAILS
                // =========================================================
                Section::make('Payment Details')
                    ->description('Vendor account and payment information.')
                    ->icon('heroicon-o-credit-card')
                    ->schema([

                        Grid::make(3)
                            ->schema([

                                TextEntry::make('account_name')
                                    ->label('Account Name')
                                    ->icon('heroicon-o-user')
                                    ->placeholder('-'),

                                TextEntry::make('account_number')
                                    ->label('Account Number')
                                    ->icon('heroicon-o-hashtag')
                                    ->placeholder('-'),

                                TextEntry::make('bank_name')
                                    ->label('Bank Name')
                                    ->icon('heroicon-o-building-library')
                                    ->placeholder('-'),

                            ]),

                        Grid::make(2)
                            ->schema([

                                TextEntry::make('branch_name')
                                    ->label('Branch Name')
                                    ->placeholder('-'),

                                TextEntry::make('transaction_id')
                                    ->label('Transaction ID')
                                    ->copyable()
                                    ->copyMessage('Transaction ID copied')
                                    ->icon('heroicon-o-clipboard-document')
                                    ->placeholder('-'),

                            ]),

                        TextEntry::make('reference_number')
                            ->label('Reference Number')
                            ->copyable()
                            ->copyMessage('Reference number copied')
                            ->icon('heroicon-o-document-duplicate')
                            ->placeholder('-'),

                    ])
                    ->columnSpanFull(),

                // =========================================================
                // PAYOUT TIMELINE
                // =========================================================
                Section::make('Payout Timeline')
                    ->description('Important dates related to this payout.')
                    ->icon('heroicon-o-clock')
                    ->schema([

                        Grid::make(3)
                            ->schema([

                                TextEntry::make('requested_at')
                                    ->label('Requested At')
                                    ->dateTime('d M Y, h:i A')
                                    ->icon('heroicon-o-calendar')
                                    ->placeholder('-'),

                                TextEntry::make('processed_at')
                                    ->label('Processed At')
                                    ->dateTime('d M Y, h:i A')
                                    ->icon('heroicon-o-arrow-path')
                                    ->placeholder('-'),

                                TextEntry::make('completed_at')
                                    ->label('Completed At')
                                    ->dateTime('d M Y, h:i A')
                                    ->icon('heroicon-o-check-circle')
                                    ->placeholder('-'),

                            ]),

                    ])
                    ->columnSpanFull(),

                // =========================================================
                // NOTES
                // =========================================================
                Section::make('Notes & Remarks')
                    ->description('Additional information and payout remarks.')
                    ->icon('heroicon-o-document-text')
                    ->schema([

                        TextEntry::make('note')
                            ->label('Admin Note')
                            ->prose()
                            ->placeholder('No note added.')
                            ->columnSpanFull(),

                        TextEntry::make('rejection_reason')
                            ->label('Rejection Reason')
                            ->color('danger')
                            ->prose()
                            ->placeholder('No rejection reason.')
                            ->columnSpanFull(),

                    ])
                    ->columnSpanFull(),

                // =========================================================
                // SYSTEM INFORMATION
                // =========================================================
                Section::make('System Information')
                    ->description('Record creation and update information.')
                    ->icon('heroicon-o-information-circle')
                    ->collapsed()
                    ->schema([

                        Grid::make(2)
                            ->schema([

                                TextEntry::make('created_at')
                                    ->label('Created At')
                                    ->dateTime('d M Y, h:i A')
                                    ->placeholder('-'),

                                TextEntry::make('updated_at')
                                    ->label('Last Updated')
                                    ->dateTime('d M Y, h:i A')
                                    ->placeholder('-'),

                            ]),

                    ])
                    ->columnSpanFull(),

            ]);
    }
}
