<?php

namespace App\Filament\Resources\Vendors\Schemas;

use Filament\Schemas\Components\Section as ComponentsSection;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class VendorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                /*
                |--------------------------------------------------------------------------
                | Vendor Information
                |--------------------------------------------------------------------------
                */

                ComponentsSection::make('Vendor Information')
                    ->description('Basic information and contact details of the vendor.')
                    ->icon('heroicon-o-user-circle')
                    ->schema([

                        Grid::make(2)
                            ->schema([

                                TextInput::make('name')
                                    ->label('Vendor Name')
                                    ->placeholder('Enter vendor name')
                                    ->required()
                                    ->maxLength(255)
                                    ->autofocus(),

                                TextInput::make('company_name')
                                    ->label('Company Name')
                                    ->placeholder('Enter company name')
                                    ->maxLength(255),

                            ]),

                        Grid::make(2)
                            ->schema([

                                TextInput::make('email')
                                    ->label('Email Address')
                                    ->placeholder('vendor@example.com')
                                    ->email()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255),

                                TextInput::make('phone')
                                    ->label('Phone Number')
                                    ->placeholder('+880 1XXXXXXXXX')
                                    ->tel()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(30),

                            ]),

                    ])
                    ->columnSpanFull(),


                /*
                |--------------------------------------------------------------------------
                | Business Address
                |--------------------------------------------------------------------------
                */

                ComponentsSection::make('Business Address')
                    ->description('Enter the vendor business location.')
                    ->icon('heroicon-o-map-pin')
                    ->schema([

                        TextInput::make('address')
                            ->label('Street Address')
                            ->placeholder('Enter complete business address')
                            ->maxLength(500)
                            ->columnSpanFull(),

                        Grid::make(2)
                            ->schema([

                                TextInput::make('city')
                                    ->label('City')
                                    ->placeholder('Enter city')
                                    ->maxLength(100),

                                TextInput::make('country')
                                    ->label('Country')
                                    ->placeholder('Enter country')
                                    ->default('Bangladesh')
                                    ->maxLength(100),

                            ]),

                    ])
                    ->columnSpanFull(),


                /*
                |--------------------------------------------------------------------------
                | Vendor Description
                |--------------------------------------------------------------------------
                */

                ComponentsSection::make('Vendor Description')
                    ->description('Add information about the vendor or business.')
                    ->icon('heroicon-o-document-text')
                    ->schema([

                        Textarea::make('description')
                            ->label('Description')
                            ->placeholder(
                                'Write a short description about this vendor or company...'
                            )
                            ->rows(6)
                            ->maxLength(3000)
                            ->columnSpanFull(),

                    ])
                    ->collapsible()
                    ->columnSpanFull(),


                /*
                |--------------------------------------------------------------------------
                | Account Status
                |--------------------------------------------------------------------------
                */

                ComponentsSection::make('Account Status')
                    ->description('Manage the vendor account status.')
                    ->icon('heroicon-o-shield-check')
                    ->schema([

                        Select::make('status')
                            ->label('Vendor Status')
                            ->options([
                                'active' => 'Active',
                                'inactive' => 'Inactive',
                                'pending' => 'Pending',
                                'suspended' => 'Suspended',
                            ])
                            ->default('active')
                            ->required()
                            ->native(false)
                            ->helperText(
                                'Choose the current status of this vendor account.'
                            ),

                    ])
                    ->columnSpanFull(),

            ]);
    }
}
