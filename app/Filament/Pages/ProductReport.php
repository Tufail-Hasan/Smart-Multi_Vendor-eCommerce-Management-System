<?php

namespace App\Filament\Pages;

use Illuminate\Support\Facades\DB;
use Filament\Support\Icons\Heroicon;

class ProductReport extends BaseReportPage
{
    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedCube;

    protected static ?string $navigationLabel = 'Product Report';

    protected static ?string $title = 'Product Report';

    protected static string|\UnitEnum|null $navigationGroup = 'Reports';

    public function getReportData(): array
    {
        $total = DB::table('products')->count();

        $lowStock = DB::table('products')
            ->whereColumn('stock', '<=', 'low_stock_threshold')
            ->count();

        $outOfStock = DB::table('products')
            ->where('stock', '<=', 0)
            ->count();

        $rows = DB::table('products')
            ->select('id', 'name', 'price', 'stock', 'status')
            ->orderBy('stock')
            ->limit(20)
            ->get()
            ->map(fn ($product) => [
                'Product ID' => $product->id,
                'Product' => $product->name,
                'Price' => '৳' . number_format((float) $product->price, 2),
                'Stock' => $product->stock,
                'Status' => $product->status,
            ])
            ->toArray();

        return [
            'title' => 'Product Report',
            'description' => 'Product catalogue and stock overview.',
            'cards' => [
                ['label' => 'Total Products', 'value' => number_format($total)],
                ['label' => 'Low Stock', 'value' => number_format($lowStock)],
                ['label' => 'Out of Stock', 'value' => number_format($outOfStock)],
            ],
            'columns' => ['Product ID', 'Product', 'Price', 'Stock', 'Status'],
            'rows' => $rows,
        ];
    }
}
