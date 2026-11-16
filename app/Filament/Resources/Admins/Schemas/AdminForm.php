<?php

namespace App\Filament\Resources\Admins\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section as ComponentsSection;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class AdminForm
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
                    ->description('Enter the administrator personal and contact information.')
                    ->icon('heroicon-o-user')
                    ->schema([

                        Grid::make(2)
                            ->schema([

                                TextInput::make('name')
                                    ->label('Full Name')
                                    ->placeholder('Enter admin full name')
                                    ->required()
                                    ->maxLength(255)
                                    ->autofocus(),

                                TextInput::make('phone')
                                    ->label('Phone Number')
                                    ->placeholder('+880 1XXXXXXXXX')
                                    ->tel()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(30),

                            ]),

                        TextInput::make('email')
                            ->label('Email Address')
                            ->placeholder('admin@example.com')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->columnSpanFull(),

                    ])
                    ->columnSpanFull(),


                /*
                |--------------------------------------------------------------------------
                | Profile Photo
                |--------------------------------------------------------------------------
                */

                ComponentsSection::make('Profile Photo')
                    ->description('Upload an administrator profile picture.')
                    ->icon('heroicon-o-camera')
                    ->schema([

                        FileUpload::make('profile_photo')
                            ->label('Admin Photo')
                            ->image()
                            ->avatar()
                            ->imageEditor()
                            ->disk('public')
                            ->directory('admins')
                            ->maxSize(2048)
                            ->acceptedFileTypes([
                                'image/jpeg',
                                'image/png',
                                'image/webp',
                            ])
                            ->helperText(
                                'Accepted formats: JPG, PNG, WebP. Maximum size: 2MB.'
                            )
                            ->columnSpanFull(),

                    ])
                    ->columnSpanFull(),


                /*
                |--------------------------------------------------------------------------
                | Role & Status
                |--------------------------------------------------------------------------
                */

                ComponentsSection::make('Role & Account Status')
                    ->description('Configure administrator access level and account status.')
                    ->icon('heroicon-o-shield-check')
                    ->schema([

                        Grid::make(2)
                            ->schema([

                                Select::make('role')
                                    ->label('Administrator Role')
                                    ->options([
                                        'super_admin' => 'Super Admin',
                                        'admin' => 'Admin',
                                        'manager' => 'Manager',
                                        'support' => 'Support',
                                    ])
                                    ->default('admin')
                                    ->required()
                                    ->native(false)
                                    ->helperText(
                                        'Select the administrator access level.'
                                    ),

                                Select::make('status')
                                    ->label('Account Status')
                                    ->options([
                                        'active' => 'Active',
                                        'inactive' => 'Inactive',
                                        'blocked' => 'Blocked',
                                    ])
                                    ->default('active')
                                    ->required()
                                    ->native(false),

                            ]),

                    ])
                    ->columnSpanFull(),


                /*
                |--------------------------------------------------------------------------
                | Password & Security
                |--------------------------------------------------------------------------
                */

                ComponentsSection::make('Password & Security')
                    ->description('Set or update the administrator password.')
                    ->icon('heroicon-o-lock-closed')
                    ->schema([

                        TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->revealable()
                            ->placeholder('Enter password')
                            ->minLength(8)
                            ->maxLength(255)

                            // Hash password before saving
                            ->dehydrateStateUsing(
                                fn ($state) => filled($state)
                                    ? Hash::make($state)
                                    : null
                            )

                            // Do not update password if empty
                            ->dehydrated(
                                fn ($state) => filled($state)
                            )

                            // Required only when creating a new admin
                            ->required(
                                fn (string $operation): bool =>
                                    $operation === 'create'
                            )

                            ->helperText(
                                'Minimum 8 characters. Leave empty while editing to keep the current password.'
                            ),

                    ])
                    ->columnSpanFull(),


                /*
                |--------------------------------------------------------------------------
                | System Information
                |--------------------------------------------------------------------------
                */

                ComponentsSection::make('System Information')
                    ->description('System-managed account information.')
                    ->icon('heroicon-o-information-circle')
                    ->schema([

                        Grid::make(2)
                            ->schema([

                                TextInput::make('email_verified_at')
                                    ->label('Email Verification')
                                    ->disabled()
                                    ->placeholder('Automatically managed'),

                                TextInput::make('last_login_at')
                                    ->label('Last Login')
                                    ->disabled()
                                    ->placeholder('No login recorded yet'),

                            ]),

                    ])
                    ->collapsible()
                    ->collapsed()
                    ->columnSpanFull(),


                /*
                |--------------------------------------------------------------------------
                | Admin Notes
                |--------------------------------------------------------------------------
                */

                ComponentsSection::make('Admin Notes')
                    ->description('Private notes visible only to authorized administrators.')
                    ->icon('heroicon-o-document-text')
                    ->schema([

                        Textarea::make('notes')
                            ->label('Notes')
                            ->placeholder('Write private notes about this administrator...')
                            ->rows(5)
                            ->maxLength(2000)
                            ->columnSpanFull(),

                    ])
                    ->collapsible()
                    ->collapsed()
                    ->columnSpanFull(),

            ]);
    }
}
