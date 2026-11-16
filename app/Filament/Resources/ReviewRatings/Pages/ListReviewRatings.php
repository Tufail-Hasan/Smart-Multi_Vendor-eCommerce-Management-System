<?php

namespace App\Filament\Resources\ReviewRatings\Pages;

use App\Filament\Resources\ReviewRatings\ReviewRatingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListReviewRatings extends ListRecords
{
    protected static string $resource = ReviewRatingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
