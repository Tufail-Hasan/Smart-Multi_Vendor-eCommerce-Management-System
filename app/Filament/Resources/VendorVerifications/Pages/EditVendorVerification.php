<?php

namespace App\Filament\Resources\VendorVerifications\Pages;

use App\Filament\Resources\VendorVerifications\VendorVerificationResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditVendorVerification extends EditRecord
{
    protected static string $resource = VendorVerificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
