<?php

namespace App\Filament\Resources\VendorVerifications\Pages;

use App\Filament\Resources\VendorVerifications\VendorVerificationResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewVendorVerification extends ViewRecord
{
    protected static string $resource = VendorVerificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
