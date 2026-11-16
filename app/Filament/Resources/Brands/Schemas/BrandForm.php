<?php

namespace App\Filament\Resources\Brands\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;

class BrandForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextInput::make('name')
                    ->label('Brand Name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('slug')
                    ->label('Brand Slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),

                Textarea::make('description')
                    ->label('Brand Description')
                    ->default(null)
                    ->columnSpanFull(),

                FileUpload::make('logo')
                    ->label('Brand Logo')
                    ->image()
                    ->disk('public')
                    ->directory('brands')
                    ->visibility('public')
                    ->imageEditor()
                    ->maxSize(5120)
                    ->required(),

                Toggle::make('is_active')
                    ->label('Active Status')
                    ->default(true)
                    ->required(),

            ]);
    }
}
