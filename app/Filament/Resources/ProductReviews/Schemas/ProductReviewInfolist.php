<?php

namespace App\Filament\Resources\ProductReviews\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ProductReviewInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('product.name')
                    ->label('Product'),
                TextEntry::make('user.name')
                    ->label('User'),
                TextEntry::make('rating')
                    ->numeric(),
                TextEntry::make('title')
                    ->placeholder('-'),
                TextEntry::make('review')
                    ->columnSpanFull(),
                IconEntry::make('is_verified_purchase')
                    ->boolean(),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('admin_reply')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('moderated_by')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('moderated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('helpful_count')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
