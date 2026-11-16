<?php

namespace App\Filament\Resources\Customers\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section as ComponentsSection;
use Filament\Schemas\Schema;

class CustomerInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                /*
                |--------------------------------------------------------------------------
                | Customer Profile
                |--------------------------------------------------------------------------
                */

                ComponentsSection::make('Customer Profile')
                    ->description('Basic customer information and account details.')
                    ->icon('heroicon-o-user-circle')
                    ->schema([

                        Grid::make(3)
                            ->schema([

                                ImageEntry::make('profile_photo')
                                    ->label('Profile Photo')
                                    ->disk('public')
                                    ->circular()
                                    ->size(100)
                                    ->defaultImageUrl(
                                        url('/images/default-avatar.png')
                                    ),

                                TextEntry::make('first_name')
                                    ->label('First Name')
                                    ->weight('bold')
                                    ->size('lg'),

                                TextEntry::make('last_name')
                                    ->label('Last Name')
                                    ->placeholder('-')
                                    ->weight('bold')
                                    ->size('lg'),

                            ]),

                        Grid::make(2)
                            ->schema([

                                TextEntry::make('email')
                                    ->label('Email Address')
                                    ->icon('heroicon-o-envelope')
                                    ->copyable()
                                    ->copyMessage('Email copied!')
                                    ->copyMessageDuration(1500),

                                TextEntry::make('phone')
                                    ->label('Phone Number')
                                    ->icon('heroicon-o-phone')
                                    ->placeholder('-')
                                    ->copyable(),

                            ]),

                        Grid::make(2)
                            ->schema([

                                TextEntry::make('gender')
                                    ->label('Gender')
                                    ->badge()
                                    ->formatStateUsing(
                                        fn (?string $state): string =>
                                            $state
                                                ? ucfirst($state)
                                                : '-'
                                    )
                                    ->color(fn (?string $state): string => match ($state) {
                                        'male' => 'info',
                                        'female' => 'success',
                                        'other' => 'warning',
                                        default => 'gray',
                                    }),

                                TextEntry::make('date_of_birth')
                                    ->label('Date of Birth')
                                    ->date('d M Y')
                                    ->icon('heroicon-o-calendar')
                                    ->placeholder('-'),

                            ]),

                    ])
                    ->columnSpanFull(),


                /*
                |--------------------------------------------------------------------------
                | Account Status
                |--------------------------------------------------------------------------
                */

                ComponentsSection::make('Account Information')
                    ->description('Customer account status and verification information.')
                    ->icon('heroicon-o-shield-check')
                    ->schema([

                        Grid::make(3)
                            ->schema([

                                TextEntry::make('status')
    ->label('Account Status')
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
        'blocked' => 'danger',
        default => 'gray',
    }),

                                TextEntry::make('email_verified_at')
                                    ->label('Email Verification')
                                    ->formatStateUsing(
                                        fn ($state): string =>
                                            $state
                                                ? 'Verified'
                                                : 'Not Verified'
                                    )
                                    ->badge()
                                    ->color(fn ($state): string =>
                                        $state ? 'success' : 'warning'
                                    ),

                                TextEntry::make('created_at')
                                    ->label('Registered At')
                                    ->dateTime('d M Y, h:i A')
                                    ->icon('heroicon-o-calendar'),

                            ]),

                    ])
                    ->columnSpanFull(),


                /*
                |--------------------------------------------------------------------------
                | Customer Statistics
                |--------------------------------------------------------------------------
                */

                ComponentsSection::make('Customer Statistics')
                    ->description('Customer purchase and order statistics.')
                    ->icon('heroicon-o-chart-bar')
                    ->schema([

                        Grid::make(3)
                            ->schema([

                                TextEntry::make('total_orders')
                                    ->label('Total Orders')
                                    ->numeric()
                                    ->icon('heroicon-o-shopping-bag')
                                    ->weight('bold')
                                    ->size('lg'),

                                TextEntry::make('total_spent')
                                    ->label('Total Spent')
                                    ->formatStateUsing(
                                        fn ($state): string =>
                                            '৳ ' . number_format((float) $state, 2)
                                    )
                                    ->icon('heroicon-o-banknotes')
                                    ->weight('bold')
                                    ->size('lg'),

                                TextEntry::make('last_order_at')
                                    ->label('Last Order')
                                    ->dateTime('d M Y, h:i A')
                                    ->icon('heroicon-o-clock')
                                    ->placeholder('No orders yet'),

                            ]),

                    ])
                    ->columnSpanFull(),


                /*
                |--------------------------------------------------------------------------
                | Admin Notes
                |--------------------------------------------------------------------------
                */

                ComponentsSection::make('Admin Notes')
                    ->description('Private notes about this customer.')
                    ->icon('heroicon-o-document-text')
                    ->schema([

                        TextEntry::make('notes')
                            ->label('Notes')
                            ->placeholder('No notes available.')
                            ->prose()
                            ->columnSpanFull(),

                    ])
                    ->collapsible()
                    ->columnSpanFull(),


                /*
                |--------------------------------------------------------------------------
                | Timestamps
                |--------------------------------------------------------------------------
                */

                ComponentsSection::make('System Information')
                    ->description('Customer record information.')
                    ->icon('heroicon-o-information-circle')
                    ->schema([

                        Grid::make(2)
                            ->schema([

                                TextEntry::make('created_at')
                                    ->label('Created At')
                                    ->dateTime('d M Y, h:i A')
                                    ->icon('heroicon-o-plus-circle'),

                                TextEntry::make('updated_at')
                                    ->label('Last Updated')
                                    ->dateTime('d M Y, h:i A')
                                    ->icon('heroicon-o-arrow-path'),

                            ]),

                    ])
                    ->collapsible()
                    ->collapsed()
                    ->columnSpanFull(),

            ]);
    }
}
