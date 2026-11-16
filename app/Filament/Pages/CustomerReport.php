<?php

namespace App\Filament\Pages;

use Illuminate\Support\Facades\DB;
use Filament\Support\Icons\Heroicon;

class CustomerReport extends BaseReportPage
{
    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static ?string $navigationLabel = 'Customer Report';

    protected static ?string $title = 'Customer Report';

    protected static string|\UnitEnum|null $navigationGroup = 'Reports';

    public function getReportData(): array
    {
        $totalCustomers = DB::table('customers')->count();

        $rows = DB::table('orders')
            ->select(
                'customer_id',
                DB::raw('COUNT(*) as total_orders'),
                DB::raw('SUM(total_amount) as total_spent')
            )
            ->whereNotNull('customer_id')
            ->groupBy('customer_id')
            ->orderByDesc('total_spent')
            ->limit(20)
            ->get()
            ->map(fn ($customer) => [
                'Customer ID' => $customer->customer_id,
                'Total Orders' => $customer->total_orders,
                'Total Spent' => '৳' . number_format((float) $customer->total_spent, 2),
            ])
            ->toArray();

        return [
            'title' => 'Customer Report',
            'description' => 'Customer orders and spending overview.',
            'cards' => [
                ['label' => 'Total Customers', 'value' => number_format($totalCustomers)],
                ['label' => 'Customers With Orders', 'value' => number_format(
                    DB::table('orders')->whereNotNull('customer_id')
                        ->distinct()->count('customer_id')
                )],
                ['label' => 'Total Orders', 'value' => number_format(
                    DB::table('orders')->count()
                )],
            ],
            'columns' => ['Customer ID', 'Total Orders', 'Total Spent'],
            'rows' => $rows,
        ];
    }
}
