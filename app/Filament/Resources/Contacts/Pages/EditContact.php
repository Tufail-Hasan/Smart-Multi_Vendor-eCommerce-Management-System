<?php

namespace App\Filament\Resources\Contacts\Pages;

use App\Filament\Resources\Contacts\ContactResource;
use Filament\Resources\Pages\EditRecord;

class EditContact extends EditRecord
{
    protected static string $resource = ContactResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (
            $data['status'] === 'replied' &&
            empty($data['replied_at'])
        ) {
            $data['replied_at'] = now();
        }

        if ($data['status'] !== 'replied') {
            $data['replied_at'] = null;
        }

        return $data;
    }
}
