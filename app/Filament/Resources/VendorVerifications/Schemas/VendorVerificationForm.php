<?php

namespace App\Filament\Resources\VendorVerifications\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section as ComponentsSection;
use Filament\Schemas\Schema;

class VendorVerificationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                /*
                |--------------------------------------------------------------------------
                | Vendor & Business Information
                |--------------------------------------------------------------------------
                */

                ComponentsSection::make('Vendor & Business Information')
                    ->description('Basic information about the vendor and registered business.')
                    ->icon('heroicon-o-building-storefront')
                    ->schema([
                        Grid::make(2)
                            ->schema([

                                Select::make('vendor_id')
                                    ->label('Vendor')
                                    ->relationship('vendor', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->native(false)
                                    ->helperText('Select the vendor requesting verification.'),

                                TextInput::make('business_name')
                                    ->label('Business Name')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Enter registered business name'),

                                TextInput::make('business_type')
                                    ->label('Business Type')
                                    ->placeholder('e.g. Retail, Wholesale, Manufacturer')
                                    ->maxLength(255),

                                TextInput::make('business_registration_number')
                                    ->label('Registration Number')
                                    ->placeholder('Enter business registration number')
                                    ->maxLength(255),

                                TextInput::make('tax_id')
                                    ->label('Tax ID / TIN')
                                    ->placeholder('Enter tax identification number')
                                    ->maxLength(255),
                            ]),
                    ])
                    ->columnSpanFull(),

                /*
                |--------------------------------------------------------------------------
                | Owner Information
                |--------------------------------------------------------------------------
                */

                ComponentsSection::make('Business Owner Information')
                    ->description('Personal and contact information of the business owner.')
                    ->icon('heroicon-o-user')
                    ->schema([
                        Grid::make(2)
                            ->schema([

                                TextInput::make('owner_name')
                                    ->label('Owner Name')
                                    ->required()
                                    ->maxLength(255)
                                    ->prefixIcon('heroicon-o-user'),

                                TextInput::make('owner_phone')
                                    ->label('Owner Phone')
                                    ->tel()
                                    ->maxLength(30)
                                    ->prefixIcon('heroicon-o-phone')
                                    ->placeholder('+880 1XXX-XXXXXX'),

                                TextInput::make('owner_email')
                                    ->label('Owner Email')
                                    ->email()
                                    ->maxLength(255)
                                    ->prefixIcon('heroicon-o-envelope')
                                    ->placeholder('owner@example.com'),
                            ]),
                    ])
                    ->columnSpanFull(),

                /*
                |--------------------------------------------------------------------------
                | Verification Documents
                |--------------------------------------------------------------------------
                */

                ComponentsSection::make('Verification Documents')
                    ->description('Upload official documents required to verify this vendor.')
                    ->icon('heroicon-o-document-check')
                    ->schema([
                        Grid::make(2)
                            ->schema([

                                FileUpload::make('business_license')
                                    ->label('Business License')
                                    ->disk('public')
                                    ->directory('vendor-verifications/business-license')
                                    ->visibility('public')
                                    ->downloadable()
                                    ->openable()
                                    ->previewable()
                                    ->maxSize(10240)
                                    ->acceptedFileTypes([
                                        'application/pdf',
                                        'image/jpeg',
                                        'image/png',
                                        'image/webp',
                                    ])
                                    ->helperText('PDF, JPG, PNG or WEBP. Max 10MB.'),

                                FileUpload::make('tax_document')
                                    ->label('Tax Document')
                                    ->disk('public')
                                    ->directory('vendor-verifications/tax-document')
                                    ->visibility('public')
                                    ->downloadable()
                                    ->openable()
                                    ->previewable()
                                    ->maxSize(10240)
                                    ->acceptedFileTypes([
                                        'application/pdf',
                                        'image/jpeg',
                                        'image/png',
                                        'image/webp',
                                    ])
                                    ->helperText('PDF, JPG, PNG or WEBP. Max 10MB.'),

                                FileUpload::make('identity_document')
                                    ->label('Identity Document')
                                    ->disk('public')
                                    ->directory('vendor-verifications/identity-document')
                                    ->visibility('public')
                                    ->downloadable()
                                    ->openable()
                                    ->previewable()
                                    ->maxSize(10240)
                                    ->acceptedFileTypes([
                                        'application/pdf',
                                        'image/jpeg',
                                        'image/png',
                                        'image/webp',
                                    ])
                                    ->helperText('PDF, JPG, PNG or WEBP. Max 10MB.'),

                                FileUpload::make('address_proof')
                                    ->label('Address Proof')
                                    ->disk('public')
                                    ->directory('vendor-verifications/address-proof')
                                    ->visibility('public')
                                    ->downloadable()
                                    ->openable()
                                    ->previewable()
                                    ->maxSize(10240)
                                    ->acceptedFileTypes([
                                        'application/pdf',
                                        'image/jpeg',
                                        'image/png',
                                        'image/webp',
                                    ])
                                    ->helperText('PDF, JPG, PNG or WEBP. Max 10MB.'),
                            ]),
                    ])
                    ->columnSpanFull(),

                /*
                |--------------------------------------------------------------------------
                | Verification Status
                |--------------------------------------------------------------------------
                */

                ComponentsSection::make('Verification Status')
                    ->description('Manage the current verification stage of this vendor.')
                    ->icon('heroicon-o-shield-check')
                    ->schema([
                        Grid::make(2)
                            ->schema([

                                Select::make('status')
                                    ->label('Verification Status')
                                    ->options([
                                        'pending' => 'Pending',
                                        'under_review' => 'Under Review',
                                        'approved' => 'Approved',
                                        'rejected' => 'Rejected',
                                        'revision_required' => 'Revision Required',
                                    ])
                                    ->default('pending')
                                    ->required()
                                    ->native(false)
                                    ->selectablePlaceholder(false)
                                    ->preload(),

                                DateTimePicker::make('submitted_at')
                                    ->label('Submitted At')
                                    ->native(false)
                                    ->seconds(false),

                                DateTimePicker::make('reviewed_at')
                                    ->label('Reviewed At')
                                    ->native(false)
                                    ->seconds(false),

                                DateTimePicker::make('verified_at')
                                    ->label('Verified At')
                                    ->native(false)
                                    ->seconds(false),
                            ]),
                    ])
                    ->columnSpanFull(),

                /*
                |--------------------------------------------------------------------------
                | Review Information
                |--------------------------------------------------------------------------
                */

                ComponentsSection::make('Review Information')
                    ->description('Information about the administrator who reviewed this verification.')
                    ->icon('heroicon-o-clipboard-document-check')
                    ->schema([
                        Grid::make(2)
                            ->schema([

                                Select::make('reviewed_by')
                                    ->label('Reviewed By')
                                    ->relationship('reviewer', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->native(false)
                                    ->placeholder('Select reviewer'),

                                Textarea::make('rejection_reason')
                                    ->label('Rejection / Revision Reason')
                                    ->rows(4)
                                    ->placeholder('Explain why the verification was rejected or revision is required.')
                                    ->columnSpanFull(),

                                Textarea::make('admin_notes')
                                    ->label('Admin Notes')
                                    ->rows(4)
                                    ->placeholder('Add internal notes about this verification.')
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
