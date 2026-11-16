<?php

namespace App\Filament\Pages;

use Illuminate\Support\Facades\DB;
use Filament\Support\Icons\Heroicon;

class OrdersReport extends BaseReportPage
{
    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedShoppingBag;

    protected static ?string $navigationLabel = 'Orders Report';

    protected static ?string $title = 'Orders Report';

    protected static string|\UnitEnum|null $navigationGroup = 'Reports';

    public function getReportData(): array
    {
        $total = DB::table('orders')->count();

        $statuses = DB::table('orders')
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->orderBy('status')
            ->get();

        $rows = $statuses->map(fn ($item) => [
            'Status' => $item->status,
            'Orders' => $item->total,
        ])->toArray();

        return [
            'title' => 'Orders Report',
            'description' => 'Order volume grouped by status.',
            'cards' => [
                ['label' => 'Total Orders', 'value' => number_format($total)],
                ['label' => 'Pending Orders', 'value' => number_format(
                    DB::table('orders')->where('status', 'pending')->count()
                )],
                ['label' => 'Cancelled Orders', 'value' => number_format(
                    DB::table('orders')->where('status', 'cancelled')->count()
                )],
            ],
            'columns' => ['Status', 'Orders'],
            'rows' => $rows,
        ];
    }
}
