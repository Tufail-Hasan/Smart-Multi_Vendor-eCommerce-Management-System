<?php

namespace App\Filament\Resources\Admins\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section as ComponentsSection;
use Filament\Schemas\Schema;

class AdminInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                /*
                |--------------------------------------------------------------------------
                | Admin Profile
                |--------------------------------------------------------------------------
                */

                ComponentsSection::make('Administrator Profile')
                    ->description('Basic information and contact details.')
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

                                TextEntry::make('name')
                                    ->label('Full Name')
                                    ->weight('bold')
                                    ->size('lg')
                                    ->icon('heroicon-o-user'),

                                TextEntry::make('phone')
                                    ->label('Phone Number')
                                    ->placeholder('-')
                                    ->icon('heroicon-o-phone')
                                    ->copyable(),

                            ]),

                        Grid::make(2)
                            ->schema([

                                TextEntry::make('email')
                                    ->label('Email Address')
                                    ->icon('heroicon-o-envelope')
                                    ->copyable()
                                    ->copyMessage('Email copied!')
                                    ->copyMessageDuration(1500),

                                TextEntry::make('role')
                                    ->label('Administrator Role')
                                    ->badge()
                                    ->formatStateUsing(
                                        fn (?string $state): string =>
                                            $state
                                                ? match ($state) {
                                                    'super_admin' => 'Super Admin',
                                                    'admin' => 'Admin',
                                                    'manager' => 'Manager',
                                                    'support' => 'Support',
                                                    default => ucfirst($state),
                                                }
                                                : '-'
                                    )
                                    ->color(fn (?string $state): string => match ($state) {
                                        'super_admin' => 'danger',
                                        'admin' => 'primary',
                                        'manager' => 'warning',
                                        'support' => 'info',
                                        default => 'gray',
                                    }),

                            ]),

                    ])
                    ->columnSpanFull(),


                /*
                |--------------------------------------------------------------------------
                | Account Status
                |--------------------------------------------------------------------------
                */

                ComponentsSection::make('Account & Security')
                    ->description('Account status and security information.')
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
                                    ->color(
                                        fn ($state): string =>
                                            $state ? 'success' : 'warning'
                                    )
                                    ->icon(
                                        fn ($state): string =>
                                            $state
                                                ? 'heroicon-o-check-circle'
                                                : 'heroicon-o-exclamation-circle'
                                    ),

                                TextEntry::make('last_login_at')
                                    ->label('Last Login')
                                    ->dateTime('d M Y, h:i A')
                                    ->placeholder('No login recorded')
                                    ->icon('heroicon-o-clock'),

                            ]),

                    ])
                    ->columnSpanFull(),


                /*
                |--------------------------------------------------------------------------
                | Admin Activity
                |--------------------------------------------------------------------------
                */

                ComponentsSection::make('Admin Activity')
                    ->description('Administrator account activity information.')
                    ->icon('heroicon-o-chart-bar')
                    ->schema([

                        Grid::make(2)
                            ->schema([

                                TextEntry::make('created_at')
                                    ->label('Account Created')
                                    ->dateTime('d M Y, h:i A')
                                    ->icon('heroicon-o-calendar'),

                                TextEntry::make('updated_at')
                                    ->label('Last Updated')
                                    ->dateTime('d M Y, h:i A')
                                    ->icon('heroicon-o-arrow-path'),

                            ]),

                    ])
                    ->columnSpanFull(),


                /*
                |--------------------------------------------------------------------------
                | Admin Notes
                |--------------------------------------------------------------------------
                */

                ComponentsSection::make('Admin Notes')
                    ->description('Private notes about this administrator.')
                    ->icon('heroicon-o-document-text')
                    ->schema([

                        TextEntry::make('notes')
                            ->label('Notes')
                            ->placeholder('No notes available.')
                            ->prose()
                            ->columnSpanFull(),

                    ])
                    ->collapsible()
                    ->collapsed()
                    ->columnSpanFull(),

            ]);
    }
}
