<?php

namespace App\Filament\Resources\ReviewRatings;

use App\Filament\Resources\ReviewRatings\Pages\CreateReviewRating;
use App\Filament\Resources\ReviewRatings\Pages\EditReviewRating;
use App\Filament\Resources\ReviewRatings\Pages\ListReviewRatings;
use App\Filament\Resources\ReviewRatings\Pages\ViewReviewRating;
use App\Filament\Resources\ReviewRatings\Schemas\ReviewRatingForm;
use App\Filament\Resources\ReviewRatings\Schemas\ReviewRatingInfolist;
use App\Filament\Resources\ReviewRatings\Tables\ReviewRatingsTable;
use App\Models\ReviewRating;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ReviewRatingResource extends Resource
{
    protected static ?string $model = ReviewRating::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'product_id';

    public static function form(Schema $schema): Schema
    {
        return ReviewRatingForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ReviewRatingInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ReviewRatingsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListReviewRatings::route('/'),
            'create' => CreateReviewRating::route('/create'),
            'view' => ViewReviewRating::route('/{record}'),
            'edit' => EditReviewRating::route('/{record}/edit'),
        ];
    }
}
