<?php

namespace App\Filament\Resources\VendorPayouts;

use App\Filament\Resources\VendorPayouts\Pages\CreateVendorPayout;
use App\Filament\Resources\VendorPayouts\Pages\EditVendorPayout;
use App\Filament\Resources\VendorPayouts\Pages\ListVendorPayouts;
use App\Filament\Resources\VendorPayouts\Pages\ViewVendorPayout;
use App\Filament\Resources\VendorPayouts\Schemas\VendorPayoutForm;
use App\Filament\Resources\VendorPayouts\Schemas\VendorPayoutInfolist;
use App\Filament\Resources\VendorPayouts\Tables\VendorPayoutsTable;
use App\Models\VendorPayout;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class VendorPayoutResource extends Resource
{
    protected static ?string $model = VendorPayout::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static UnitEnum|string|null $navigationGroup = 'Vendor Management';

    protected static ?string $recordTitleAttribute = 'vendor_id';

    public static function form(Schema $schema): Schema
    {
        return VendorPayoutForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return VendorPayoutInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VendorPayoutsTable::configure($table);
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
            'index' => ListVendorPayouts::route('/'),
            'create' => CreateVendorPayout::route('/create'),
            'view' => ViewVendorPayout::route('/{record}'),
            'edit' => EditVendorPayout::route('/{record}/edit'),
        ];
    }
}
