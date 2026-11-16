<?php

namespace App\Filament\Resources\ReviewRatings\Pages;

use App\Filament\Resources\ReviewRatings\ReviewRatingResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewReviewRating extends ViewRecord
{
    protected static string $resource = ReviewRatingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
