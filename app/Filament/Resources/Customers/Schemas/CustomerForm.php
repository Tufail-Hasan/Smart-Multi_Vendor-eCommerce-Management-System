<?php

namespace App\Filament\Resources\Customers\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section as ComponentsSection;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class CustomerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                /*
                |--------------------------------------------------------------------------
                | Customer Information
                |--------------------------------------------------------------------------
                */

                ComponentsSection::make('Customer Information')
                    ->description('Basic information about the customer.')
                    ->icon('heroicon-o-user')
                    ->schema([

                        Grid::make(2)
                            ->schema([

                                TextInput::make('first_name')
                                    ->label('First Name')
                                    ->placeholder('Enter first name')
                                    ->required()
                                    ->maxLength(100)
                                    ->autofocus(),

                                TextInput::make('last_name')
                                    ->label('Last Name')
                                    ->placeholder('Enter last name')
                                    ->maxLength(100),

                            ]),

                        Grid::make(2)
                            ->schema([

                                TextInput::make('email')
                                    ->label('Email Address')
                                    ->placeholder('customer@example.com')
                                    ->email()
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255),

                                TextInput::make('phone')
                                    ->label('Phone Number')
                                    ->placeholder('+880 1XXXXXXXXX')
                                    ->tel()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(30),

                            ]),

                        Grid::make(2)
                            ->schema([

                                Select::make('gender')
                                    ->label('Gender')
                                    ->placeholder('Select gender')
                                    ->options([
                                        'male' => 'Male',
                                        'female' => 'Female',
                                        'other' => 'Other',
                                    ])
                                    ->native(false),

                                DatePicker::make('date_of_birth')
                                    ->label('Date of Birth')
                                    ->placeholder('Select date')
                                    ->native(false)
                                    ->maxDate(now()),

                            ]),

                    ])
                    ->columns(1)
                    ->columnSpanFull(),


                /*
                |--------------------------------------------------------------------------
                | Profile Photo
                |--------------------------------------------------------------------------
                */

                ComponentsSection::make('Profile Photo')
                    ->description('Upload a profile photo for the customer.')
                    ->icon('heroicon-o-camera')
                    ->schema([

                        FileUpload::make('profile_photo')
                            ->label('Customer Photo')
                            ->image()
                            ->imageEditor()
                            ->avatar()
                            ->directory('customers')
                            ->disk('public')
                            ->maxSize(2048)
                            ->acceptedFileTypes([
                                'image/jpeg',
                                'image/png',
                                'image/webp',
                            ])
                            ->helperText(
                                'Recommended: JPG, PNG or WebP. Maximum size: 2MB.'
                            )
                            ->columnSpanFull(),

                    ])
                    ->columnSpanFull(),


                /*
                |--------------------------------------------------------------------------
                | Account & Security
                |--------------------------------------------------------------------------
                */

                ComponentsSection::make('Account & Security')
                    ->description('Manage customer login credentials and account status.')
                    ->icon('heroicon-o-shield-check')
                    ->schema([

                        Grid::make(2)
                            ->schema([

                                TextInput::make('password')
                                    ->label('Password')
                                    ->password()
                                    ->revealable()
                                    ->placeholder('Enter password')
                                    ->minLength(8)
                                    ->maxLength(255)
                                    ->dehydrateStateUsing(
                                        fn ($state) =>
                                            filled($state)
                                                ? Hash::make($state)
                                                : null
                                    )
                                    ->dehydrated(
                                        fn ($state) => filled($state)
                                    )
                                    ->required(fn (string $operation): bool =>
                                        $operation === 'create'
                                    )
                                    ->helperText(
                                        'Leave empty when editing to keep the current password.'
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
                                    ->native(false)
                                    ->selectablePlaceholder(false),

                            ]),

                    ])
                    ->columnSpanFull(),


                /*
                |--------------------------------------------------------------------------
                | Admin Notes
                |--------------------------------------------------------------------------
                */

                ComponentsSection::make('Admin Notes')
                    ->description('Private notes visible only to administrators.')
                    ->icon('heroicon-o-document-text')
                    ->schema([

                        Textarea::make('notes')
                            ->label('Notes')
                            ->placeholder('Write any private notes about this customer...')
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
