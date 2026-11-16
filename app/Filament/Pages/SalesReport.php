<?php

namespace App\Filament\Pages;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Filament\Support\Icons\Heroicon;

class SalesReport extends BaseReportPage
{
    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedChartBar;

    protected static ?string $navigationLabel = 'Sales Report';

    protected static ?string $title = 'Sales Report';

    protected static string|\UnitEnum|null $navigationGroup = 'Reports';

    public function getReportData(): array
    {
        $orders = DB::table('orders');

        $totalOrders = (clone $orders)->count();

        $totalSales = (clone $orders)
            ->sum('total_amount');

        $averageOrderValue = $totalOrders > 0
            ? $totalSales / $totalOrders
            : 0;

        $rows = DB::table('orders')
            ->select('id', 'status', 'total_amount', 'created_at')
            ->orderByDesc('created_at')
            ->limit(20)
            ->get()
            ->map(fn ($order) => [
                'Order ID' => $order->id,
                'Status' => $order->status,
                'Amount' => number_format((float) $order->total_amount, 2),
                'Date' => $order->created_at,
            ])
            ->toArray();

        return [
            'title' => 'Sales Report',
            'description' => 'Sales performance and order summary.',
            'cards' => [
                ['label' => 'Total Sales', 'value' => '৳' . number_format((float) $totalSales, 2)],
                ['label' => 'Total Orders', 'value' => number_format($totalOrders)],
                ['label' => 'Average Order Value', 'value' => '৳' . number_format((float) $averageOrderValue, 2)],
            ],
            'columns' => ['Order ID', 'Status', 'Amount', 'Date'],
            'rows' => $rows,
        ];
    }
}
