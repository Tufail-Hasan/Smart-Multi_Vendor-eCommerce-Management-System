<?php

namespace App\Filament\Resources\Vendors\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section as ComponentsSection;
use Filament\Schemas\Schema;

class VendorInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                /*
                |--------------------------------------------------------------------------
                | Vendor Profile
                |--------------------------------------------------------------------------
                */

                ComponentsSection::make('Vendor Profile')
                    ->description('Basic vendor and business information.')
                    ->icon('heroicon-o-building-storefront')
                    ->schema([

                        Grid::make(2)
                            ->schema([

                                TextEntry::make('name')
                                    ->label('Vendor Name')
                                    ->weight('bold')
                                    ->size('lg')
                                    ->icon('heroicon-o-user'),

                                TextEntry::make('company_name')
                                    ->label('Company Name')
                                    ->placeholder('-')
                                    ->weight('bold')
                                    ->icon('heroicon-o-building-office'),

                            ]),

                        Grid::make(2)
                            ->schema([

                                TextEntry::make('email')
                                    ->label('Email Address')
                                    ->placeholder('-')
                                    ->icon('heroicon-o-envelope')
                                    ->copyable()
                                    ->copyMessage('Email copied!')
                                    ->copyMessageDuration(1500),

                                TextEntry::make('phone')
                                    ->label('Phone Number')
                                    ->placeholder('-')
                                    ->icon('heroicon-o-phone')
                                    ->copyable(),

                            ]),

                    ])
                    ->columnSpanFull(),


                /*
                |--------------------------------------------------------------------------
                | Business Address
                |--------------------------------------------------------------------------
                */

                ComponentsSection::make('Business Address')
                    ->description('Vendor business location information.')
                    ->icon('heroicon-o-map-pin')
                    ->schema([

                        TextEntry::make('address')
                            ->label('Street Address')
                            ->placeholder('-')
                            ->icon('heroicon-o-map'),

                        Grid::make(2)
                            ->schema([

                                TextEntry::make('city')
                                    ->label('City')
                                    ->placeholder('-')
                                    ->icon('heroicon-o-building-office-2'),

                                TextEntry::make('country')
                                    ->label('Country')
                                    ->placeholder('-')
                                    ->icon('heroicon-o-globe-alt'),

                            ]),

                    ])
                    ->columnSpanFull(),


                /*
                |--------------------------------------------------------------------------
                | Vendor Status
                |--------------------------------------------------------------------------
                */

                ComponentsSection::make('Account Status')
                    ->description('Current vendor account status.')
                    ->icon('heroicon-o-shield-check')
                    ->schema([

                        TextEntry::make('status')
                            ->label('Vendor Status')
                            ->badge()
                            ->formatStateUsing(
                                fn (?string $state): string =>
                                    $state
                                        ? ucfirst($state)
                                        : '-'
                            )
                            ->color(fn (?string $state): string => match ($state) {
                                'active' => 'success',
                                'inactive' => 'warning',
                                'pending' => 'info',
                                'suspended' => 'danger',
                                default => 'gray',
                            })
                            ->icon(fn (?string $state): string => match ($state) {
                                'active' => 'heroicon-o-check-circle',
                                'inactive' => 'heroicon-o-pause-circle',
                                'pending' => 'heroicon-o-clock',
                                'suspended' => 'heroicon-o-no-symbol',
                                default => 'heroicon-o-question-mark-circle',
                            }),

                    ])
                    ->columnSpanFull(),


                /*
                |--------------------------------------------------------------------------
                | Vendor Description
                |--------------------------------------------------------------------------
                */

                ComponentsSection::make('Description')
                    ->description('Vendor business description.')
                    ->icon('heroicon-o-document-text')
                    ->schema([

                        TextEntry::make('description')
                            ->label('About Vendor')
                            ->placeholder('No description available.')
                            ->prose()
                            ->columnSpanFull(),

                    ])
                    ->collapsible()
                    ->columnSpanFull(),


                /*
                |--------------------------------------------------------------------------
                | System Information
                |--------------------------------------------------------------------------
                */

                ComponentsSection::make('System Information')
                    ->description('Vendor record information.')
                    ->icon('heroicon-o-information-circle')
                    ->schema([

                        Grid::make(2)
                            ->schema([

                                TextEntry::make('created_at')
                                    ->label('Created At')
                                    ->dateTime('d M Y, h:i A')
                                    ->placeholder('-')
                                    ->icon('heroicon-o-plus-circle'),

                                TextEntry::make('updated_at')
                                    ->label('Last Updated')
                                    ->dateTime('d M Y, h:i A')
                                    ->placeholder('-')
                                    ->icon('heroicon-o-arrow-path'),

                            ]),

                    ])
                    ->collapsible()
                    ->collapsed()
                    ->columnSpanFull(),

            ]);
    }
}
