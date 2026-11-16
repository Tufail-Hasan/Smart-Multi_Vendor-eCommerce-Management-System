<?php

namespace App\Filament\Resources\ReviewRatings\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Forms\Components\FileUpload;

class ReviewRatingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('product_id')
                    ->relationship('product', 'name')
                    ->required(),
                Select::make('customer_id')
                    ->relationship('customer', 'id')
                    ->required(),
                TextInput::make('rating')
                    ->required()
                    ->numeric(),
                TextInput::make('title')
                    ->default(null),
                Textarea::make('review')
                    ->default(null)
                    ->columnSpanFull(),
                FileUpload::make('image')
                    ->label('Product Image')
                    ->image()
                    ->disk('public')
                    ->directory('products')
                    ->visibility('public'),
                Toggle::make('is_verified_purchase')
                    ->required(),
                TextInput::make('status')
                    ->required()
                    ->default('pending'),
                Textarea::make('admin_reply')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('replied_by')
                    ->numeric()
                    ->default(null),
                DateTimePicker::make('replied_at'),
                TextInput::make('helpful_count')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('report_count')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
