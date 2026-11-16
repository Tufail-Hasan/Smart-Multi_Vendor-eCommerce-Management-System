<?php

namespace App\Filament\Resources\VendorVerifications\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section as ComponentsSection;
use Filament\Schemas\Schema;

class VendorVerificationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                /*
                |--------------------------------------------------------------------------
                | Vendor & Business Profile
                |--------------------------------------------------------------------------
                */

                ComponentsSection::make('Vendor & Business Profile')
                    ->description('Registered vendor and business information.')
                    ->icon('heroicon-o-building-storefront')
                    ->schema([
                        Grid::make(2)
                            ->schema([

                                TextEntry::make('vendor.name')
                                    ->label('Vendor')
                                    ->icon('heroicon-o-user')
                                    ->weight('bold')
                                    ->placeholder('-'),

                                TextEntry::make('business_name')
                                    ->label('Business Name')
                                    ->icon('heroicon-o-building-office')
                                    ->weight('bold'),

                                TextEntry::make('business_type')
                                    ->label('Business Type')
                                    ->badge()
                                    ->color('gray')
                                    ->placeholder('-'),

                                TextEntry::make('business_registration_number')
                                    ->label('Registration Number')
                                    ->copyable()
                                    ->placeholder('-'),

                                TextEntry::make('tax_id')
                                    ->label('Tax ID / TIN')
                                    ->copyable()
                                    ->placeholder('-'),
                            ]),
                    ])
                    ->columnSpanFull(),

                /*
                |--------------------------------------------------------------------------
                | Owner Information
                |--------------------------------------------------------------------------
                */

                ComponentsSection::make('Business Owner')
                    ->description('Owner contact and identification information.')
                    ->icon('heroicon-o-user-circle')
                    ->schema([
                        Grid::make(3)
                            ->schema([

                                TextEntry::make('owner_name')
                                    ->label('Owner Name')
                                    ->icon('heroicon-o-user')
                                    ->weight('bold'),

                                TextEntry::make('owner_phone')
                                    ->label('Phone')
                                    ->icon('heroicon-o-phone')
                                    ->copyable()
                                    ->placeholder('-'),

                                TextEntry::make('owner_email')
                                    ->label('Email')
                                    ->icon('heroicon-o-envelope')
                                    ->copyable()
                                    ->placeholder('-'),
                            ]),
                    ])
                    ->columnSpanFull(),

                /*
                |--------------------------------------------------------------------------
                | Verification Status
                |--------------------------------------------------------------------------
                */

                ComponentsSection::make('Verification Status')
                    ->description('Current verification status and timeline.')
                    ->icon('heroicon-o-shield-check')
                    ->schema([
                        Grid::make(2)
                            ->schema([

                                TextEntry::make('status')
                                    ->label('Current Status')
                                    ->badge()
                                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                                        'pending' => 'Pending',
                                        'under_review' => 'Under Review',
                                        'approved' => 'Approved',
                                        'rejected' => 'Rejected',
                                        'revision_required' => 'Revision Required',
                                        default => ucfirst(str_replace('_', ' ', $state ?? '-')),
                                    })
                                    ->color(fn (?string $state): string => match ($state) {
                                        'pending' => 'warning',
                                        'under_review' => 'info',
                                        'approved' => 'success',
                                        'rejected' => 'danger',
                                        'revision_required' => 'warning',
                                        default => 'gray',
                                    })
                                    ->icon(fn (?string $state): string => match ($state) {
                                        'pending' => 'heroicon-o-clock',
                                        'under_review' => 'heroicon-o-magnifying-glass',
                                        'approved' => 'heroicon-o-check-circle',
                                        'rejected' => 'heroicon-o-x-circle',
                                        'revision_required' => 'heroicon-o-exclamation-triangle',
                                        default => 'heroicon-o-question-mark-circle',
                                    }),

                                TextEntry::make('submitted_at')
                                    ->label('Submitted At')
                                    ->dateTime('d M Y, h:i A')
                                    ->icon('heroicon-o-calendar')
                                    ->placeholder('-'),

                                TextEntry::make('reviewed_at')
                                    ->label('Reviewed At')
                                    ->dateTime('d M Y, h:i A')
                                    ->icon('heroicon-o-calendar-days')
                                    ->placeholder('-'),

                                TextEntry::make('verified_at')
                                    ->label('Verified At')
                                    ->dateTime('d M Y, h:i A')
                                    ->icon('heroicon-o-check-badge')
                                    ->placeholder('-'),
                            ]),
                    ])
                    ->columnSpanFull(),

                /*
                |--------------------------------------------------------------------------
                | Verification Documents
                |--------------------------------------------------------------------------
                */

                ComponentsSection::make('Verification Documents')
                    ->description('Official documents submitted by the vendor.')
                    ->icon('heroicon-o-document-duplicate')
                    ->schema([
                        Grid::make(2)
                            ->schema([

                                TextEntry::make('business_license')
                                    ->label('Business License')
                                    ->icon('heroicon-o-document-text')
                                    ->formatStateUsing(fn ($state) => $state ? 'View Business License' : '-')
                                    ->url(
                                        fn ($record) => $record?->business_license
                                            ? asset('storage/' . $record->business_license)
                                            : null
                                    )
                                    ->openUrlInNewTab()
                                    ->color('primary')
                                    ->weight('bold')
                                    ->placeholder('Not uploaded'),

                                TextEntry::make('tax_document')
                                    ->label('Tax Document')
                                    ->icon('heroicon-o-document-text')
                                    ->formatStateUsing(fn ($state) => $state ? 'View Tax Document' : '-')
                                    ->url(
                                        fn ($record) => $record?->tax_document
                                            ? asset('storage/' . $record->tax_document)
                                            : null
                                    )
                                    ->openUrlInNewTab()
                                    ->color('primary')
                                    ->weight('bold')
                                    ->placeholder('Not uploaded'),

                                TextEntry::make('identity_document')
                                    ->label('Identity Document')
                                    ->icon('heroicon-o-identification')
                                    ->formatStateUsing(fn ($state) => $state ? 'View Identity Document' : '-')
                                    ->url(
                                        fn ($record) => $record?->identity_document
                                            ? asset('storage/' . $record->identity_document)
                                            : null
                                    )
                                    ->openUrlInNewTab()
                                    ->color('primary')
                                    ->weight('bold')
                                    ->placeholder('Not uploaded'),

                                TextEntry::make('address_proof')
                                    ->label('Address Proof')
                                    ->icon('heroicon-o-map-pin')
                                    ->formatStateUsing(fn ($state) => $state ? 'View Address Proof' : '-')
                                    ->url(
                                        fn ($record) => $record?->address_proof
                                            ? asset('storage/' . $record->address_proof)
                                            : null
                                    )
                                    ->openUrlInNewTab()
                                    ->color('primary')
                                    ->weight('bold')
                                    ->placeholder('Not uploaded'),
                            ]),
                    ])
                    ->columnSpanFull(),

                /*
                |--------------------------------------------------------------------------
                | Review Information
                |--------------------------------------------------------------------------
                */

                ComponentsSection::make('Review Information')
                    ->description('Administrator review and decision details.')
                    ->icon('heroicon-o-clipboard-document-check')
                    ->schema([
                        Grid::make(2)
                            ->schema([

                                TextEntry::make('reviewer.name')
                                    ->label('Reviewed By')
                                    ->icon('heroicon-o-user')
                                    ->weight('bold')
                                    ->placeholder('Not reviewed yet'),

                                TextEntry::make('rejection_reason')
                                    ->label('Rejection / Revision Reason')
                                    ->icon('heroicon-o-exclamation-circle')
                                    ->placeholder('No reason provided')
                                    ->columnSpanFull(),

                                TextEntry::make('admin_notes')
                                    ->label('Admin Notes')
                                    ->icon('heroicon-o-pencil-square')
                                    ->placeholder('No admin notes')
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpanFull(),

                /*
                |--------------------------------------------------------------------------
                | System Information
                |--------------------------------------------------------------------------
                */

                ComponentsSection::make('System Information')
                    ->description('Record creation and update information.')
                    ->icon('heroicon-o-information-circle')
                    ->collapsed()
                    ->schema([
                        Grid::make(2)
                            ->schema([

                                TextEntry::make('created_at')
                                    ->label('Created At')
                                    ->dateTime('d M Y, h:i A')
                                    ->icon('heroicon-o-calendar'),

                                TextEntry::make('updated_at')
                                    ->label('Last Updated')
                                    ->dateTime('d M Y, h:i A')
                                    ->icon('heroicon-o-arrow-path'),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
