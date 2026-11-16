<?php

namespace App\Filament\Pages;

use Illuminate\Support\Facades\DB;
use Filament\Support\Icons\Heroicon;

class VendorReport extends BaseReportPage
{
    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingStorefront;

    protected static ?string $navigationLabel = 'Vendor Report';

    protected static ?string $title = 'Vendor Report';

    protected static string|\UnitEnum|null $navigationGroup = 'Reports';

    public function getReportData(): array
    {
        $totalVendors = DB::table('vendors')->count();

        $rows = DB::table('vendors')
            ->leftJoin('products', 'vendors.id', '=', 'products.vendor_id')
            ->select(
                'vendors.id as vendor_id',
                DB::raw('COUNT(products.id) as total_products')
            )
            ->groupBy('vendors.id')
            ->orderByDesc('total_products')
            ->limit(20)
            ->get()
            ->map(fn ($vendor) => [
                'Vendor ID' => $vendor->vendor_id,
                'Total Products' => $vendor->total_products,
            ])
            ->toArray();

        return [
            'title' => 'Vendor Report',
            'description' => 'Vendor catalogue and product distribution.',
            'cards' => [
                ['label' => 'Total Vendors', 'value' => number_format($totalVendors)],
                ['label' => 'Vendors With Products', 'value' => number_format(
                    DB::table('products')->distinct('vendor_id')->count('vendor_id')
                )],
                ['label' => 'Total Products', 'value' => number_format(
                    DB::table('products')->count()
                )],
            ],
            'columns' => ['Vendor ID', 'Total Products'],
            'rows' => $rows,
        ];
    }
}