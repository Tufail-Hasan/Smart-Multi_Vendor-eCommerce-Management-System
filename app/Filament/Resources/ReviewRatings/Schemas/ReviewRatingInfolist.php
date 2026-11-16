<?php

namespace App\Filament\Resources\ReviewRatings\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ReviewRatingInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('product.name')
                    ->label('Product'),
                TextEntry::make('customer.id')
                    ->label('Customer'),
                TextEntry::make('rating')
                    ->numeric(),
                TextEntry::make('title')
                    ->placeholder('-'),
                TextEntry::make('review')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('images')
                    ->placeholder('-')
                    ->columnSpanFull(),
                IconEntry::make('is_verified_purchase')
                    ->boolean(),
                TextEntry::make('status'),
                TextEntry::make('admin_reply')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('replied_by')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('replied_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('helpful_count')
                    ->numeric(),
                TextEntry::make('report_count')
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
