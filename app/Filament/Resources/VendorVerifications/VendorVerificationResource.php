<?php

namespace App\Filament\Resources\VendorVerifications;

use App\Filament\Resources\VendorVerifications\Pages\CreateVendorVerification;
use App\Filament\Resources\VendorVerifications\Pages\EditVendorVerification;
use App\Filament\Resources\VendorVerifications\Pages\ListVendorVerifications;
use App\Filament\Resources\VendorVerifications\Pages\ViewVendorVerification;
use App\Filament\Resources\VendorVerifications\Schemas\VendorVerificationForm;
use App\Filament\Resources\VendorVerifications\Schemas\VendorVerificationInfolist;
use App\Filament\Resources\VendorVerifications\Tables\VendorVerificationsTable;
use App\Models\VendorVerification;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class VendorVerificationResource extends Resource
{
    protected static ?string $model = VendorVerification::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static UnitEnum|string|null $navigationGroup = 'Vendor Management';

    protected static ?string $recordTitleAttribute = 'vendor_id';

    public static function form(Schema $schema): Schema
    {
        return VendorVerificationForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return VendorVerificationInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VendorVerificationsTable::configure($table);
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
            'index' => ListVendorVerifications::route('/'),
            'create' => CreateVendorVerification::route('/create'),
            'view' => ViewVendorVerification::route('/{record}'),
            'edit' => EditVendorVerification::route('/{record}/edit'),
        ];
    }
}
