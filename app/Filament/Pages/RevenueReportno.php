<?php

namespace App\Filament\Pages;

use Illuminate\Support\Facades\DB;
use Filament\Support\Icons\Heroicon;

class RevenueReport extends BaseReportPage
{
    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedBanknotes;

    protected static ?string $navigationLabel = 'Revenue Report';

    protected static ?string $title = 'Revenue Report';

    protected static string|\UnitEnum|null $navigationGroup = 'Reports';

    public function getReportData(): array
    {
        $completedTransactions = DB::table('transactions')
            ->where('status', 'completed');

        $totalTransactions = (clone $completedTransactions)->count();

        $totalAmount = (clone $completedTransactions)->sum('amount');

        $rows = DB::table('transactions')
            ->select(
                'id',
                'transaction_number',
                'type',
                'amount',
                'status',
                'created_at'
            )
            ->where('status', 'completed')
            ->orderByDesc('created_at')
            ->limit(20)
            ->get()
            ->map(fn ($transaction) => [
                'Transaction ID' => $transaction->transaction_number,
                'Type' => $transaction->type,
                'Amount' => '৳' . number_format((float) $transaction->amount, 2),
                'Status' => $transaction->status,
                'Date' => $transaction->created_at,
            ])
            ->toArray();

        return [
            'title' => 'Revenue Report',
            'description' => 'Completed transaction summary.',
            'cards' => [
                ['label' => 'Completed Transactions', 'value' => number_format($totalTransactions)],
                ['label' => 'Completed Transaction Amount', 'value' => '৳' . number_format((float) $totalAmount, 2)],
                ['label' => 'Pending Transactions', 'value' => number_format(
                    DB::table('transactions')->where('status', 'pending')->count()
                )],
            ],
            'columns' => ['Transaction ID', 'Type', 'Amount', 'Status', 'Date'],
            'rows' => $rows,
        ];
    }
}
