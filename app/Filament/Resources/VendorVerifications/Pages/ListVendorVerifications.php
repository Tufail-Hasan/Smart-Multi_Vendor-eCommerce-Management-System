<?php

namespace App\Filament\Resources\VendorVerifications\Pages;

use App\Filament\Resources\VendorVerifications\VendorVerificationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListVendorVerifications extends ListRecords
{
    protected static string $resource = VendorVerificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
