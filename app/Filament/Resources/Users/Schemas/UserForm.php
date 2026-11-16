<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section as ComponentsSection;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class UserForm
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

                ComponentsSection::make('Basic Information')
                    ->description('Enter the user personal information.')
                    ->icon('heroicon-o-user')
                    ->schema([

                        TextInput::make('name')
                            ->label('Full Name')
                            ->placeholder('Enter full name')
                            ->required()
                            ->maxLength(255)
                            ->prefixIcon('heroicon-o-user'),

                        TextInput::make('email')
                            ->label('Email Address')
                            ->placeholder('example@email.com')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->prefixIcon('heroicon-o-envelope'),

                        TextInput::make('phone')
                            ->label('Phone Number')
                            ->placeholder('+880 1XXXXXXXXX')
                            ->tel()
                            ->maxLength(20)
                            ->prefixIcon('heroicon-o-phone')
                            ->nullable(),

                        TextInput::make('avatar')
                            ->label('Avatar URL')
                            ->placeholder('https://example.com/avatar.jpg')
                            ->url()
                            ->maxLength(255)
                            ->prefixIcon('heroicon-o-photo')
                            ->nullable(),

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

                ComponentsSection::make('Account Security')
                    ->description('Manage user password and email verification.')
                    ->icon('heroicon-o-shield-check')
                    ->schema([

                        TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->revealable()
                            ->placeholder('Enter password')
                            ->required(fn (string $operation): bool => $operation === 'create')
                            ->dehydrated(fn ($state): bool => filled($state))
                            ->dehydrateStateUsing(
                                fn ($state) => filled($state)
                                    ? Hash::make($state)
                                    : null
                            )
                            ->minLength(8)
                            ->maxLength(255)
                            ->prefixIcon('heroicon-o-lock-closed'),

                        DateTimePicker::make('email_verified_at')
                            ->label('Email Verified At')
                            ->native(false)
                            ->displayFormat('d M Y, h:i A')
                            ->placeholder('Select verification date')
                            ->prefixIcon('heroicon-o-check-circle'),

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

                ComponentsSection::make('User Settings')
                    ->description('Control user role and account status.')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->schema([

                        Select::make('role')
                            ->label('User Role')
                            ->options([
                                'admin' => 'Admin',
                                'vendor' => 'Vendor',
                                'customer' => 'Customer',
                            ])
                            ->default('customer')
                            ->required()
                            ->native(false)
                            ->prefixIcon('heroicon-o-user-group'),

                        Toggle::make('status')
                            ->label('Account Status')
                            ->helperText('Enable or disable this user account.')
                            ->default(true)
                            ->required()
                            ->inline(false),

                    ])
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ]),
            ]);
    }
}
