<?php

namespace App\Filament\Resources\ProductReviews\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProductReviewForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('product_id')
                    ->relationship('product', 'name')
                    ->required(),
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                TextInput::make('rating')
                    ->required()
                    ->numeric(),
                TextInput::make('title')
                    ->default(null),
                Textarea::make('review')
                    ->required()
                    ->columnSpanFull(),
                Toggle::make('is_verified_purchase')
                    ->required(),
                Select::make('status')
                    ->options(['pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected'])
                    ->default('pending')
                    ->required(),
                Textarea::make('admin_reply')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('moderated_by')
                    ->numeric()
                    ->default(null),
                DateTimePicker::make('moderated_at'),
                TextInput::make('helpful_count')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
