<?php

namespace App\Filament\Resources\ReviewRatings\Pages;

use App\Filament\Resources\ReviewRatings\ReviewRatingResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditReviewRating extends EditRecord
{
    protected static string $resource = ReviewRatingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
