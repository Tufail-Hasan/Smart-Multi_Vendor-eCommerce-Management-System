<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                /*
                |--------------------------------------------------------------------------
                | Basic Information
                |--------------------------------------------------------------------------
                */

                Section::make('Basic Information')
                    ->description('Personal and contact information of the user.')
                    ->icon('heroicon-o-user')
                    ->schema([

                        ImageEntry::make('avatar')
                            ->label('Profile Avatar')
                            ->circular()
                            ->size(90)
                            ->defaultImageUrl(
                                fn ($record) => 'https://ui-avatars.com/api/?name=' .
                                    urlencode($record->name) .
                                    '&background=random'
                            )
                            ->columnSpanFull(),

                        TextEntry::make('name')
                            ->label('Full Name')
                            ->icon('heroicon-o-user')
                            ->weight('bold')
                            ->size('lg'),

                        TextEntry::make('email')
                            ->label('Email Address')
                            ->icon('heroicon-o-envelope')
                            ->copyable()
                            ->copyMessage('Email address copied!')
                            ->placeholder('-'),

                        TextEntry::make('phone')
                            ->label('Phone Number')
                            ->icon('heroicon-o-phone')
                            ->copyable()
                            ->copyMessage('Phone number copied!')
                            ->placeholder('-'),

                    ])
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ]),

                /*
                |--------------------------------------------------------------------------
                | Account Security
                |--------------------------------------------------------------------------
                */

                Section::make('Account Security')
                    ->description('Email verification and account security information.')
                    ->icon('heroicon-o-shield-check')
                    ->schema([

                        IconEntry::make('email_verified_at')
                            ->label('Email Verification')
                            ->state(fn ($record): bool => ! is_null($record->email_verified_at))
                            ->boolean()
                            ->trueIcon('heroicon-o-check-badge')
                            ->falseIcon('heroicon-o-exclamation-circle')
                            ->trueColor('success')
                            ->falseColor('warning'),

                        TextEntry::make('email_verified_at')
                            ->label('Verified At')
                            ->dateTime('d M Y, h:i A')
                            ->icon('heroicon-o-calendar-days')
                            ->placeholder('Not verified yet'),

                    ])
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ]),

                /*
                |--------------------------------------------------------------------------
                | User Settings
                |--------------------------------------------------------------------------
                */

                Section::make('User Settings')
                    ->description('Role and current account status.')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->schema([

                        TextEntry::make('role')
                            ->label('User Role')
                            ->badge()
                            ->icon(
                                fn ($state): string => match ($state) {
                                    'admin' => 'heroicon-o-shield-check',
                                    'vendor' => 'heroicon-o-building-storefront',
                                    'customer' => 'heroicon-o-user',
                                    default => 'heroicon-o-user',
                                }
                            )
                            ->color(
                                fn ($state): string => match ($state) {
                                    'admin' => 'danger',
                                    'vendor' => 'warning',
                                    'customer' => 'success',
                                    default => 'gray',
                                }
                            )
                            ->formatStateUsing(
                                fn ($state): string => ucfirst($state ?? 'Unknown')
                            ),

                        IconEntry::make('status')
                            ->label('Account Status')
                            ->boolean()
                            ->trueIcon('heroicon-o-check-circle')
                            ->falseIcon('heroicon-o-x-circle')
                            ->trueColor('success')
                            ->falseColor('danger'),

                    ])
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ]),

                /*
                |--------------------------------------------------------------------------
                | System Information
                |--------------------------------------------------------------------------
                */

                Section::make('System Information')
                    ->description('User record creation and update information.')
                    ->icon('heroicon-o-information-circle')
                    ->schema([

                        TextEntry::make('created_at')
                            ->label('Created At')
                            ->dateTime('d M Y, h:i A')
                            ->icon('heroicon-o-calendar-days')
                            ->placeholder('-'),

                        TextEntry::make('updated_at')
                            ->label('Last Updated')
                            ->dateTime('d M Y, h:i A')
                            ->icon('heroicon-o-arrow-path')
                            ->placeholder('-'),

                    ])
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ])
                    ->collapsed(),

            ]);
    }
}
