<?php

namespace App\Filament\Widgets;

use App\Models\ArcheryParticipant;
use App\Models\Expense;
use App\Models\Income;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class YouthStatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $start = now()->startOfMonth();
        $end = now()->endOfMonth();
        $incomeThisMonth = (int) Income::query()->whereBetween('date', [$start, $end])->sum('amount');
        $expenseThisMonth = (int) Expense::query()->whereBetween('date', [$start, $end])->sum('amount');
        $balance = (int) Income::query()->sum('amount') - (int) Expense::query()->sum('amount');

        return [
            Stat::make('Total Peserta', ArcheryParticipant::query()->count()),
            Stat::make('Peserta Aktif', ArcheryParticipant::query()->active()->count()),
            Stat::make('Pemasukan Bulan Ini', 'Rp '.number_format($incomeThisMonth, 0, ',', '.')),
            Stat::make('Pengeluaran Bulan Ini', 'Rp '.number_format($expenseThisMonth, 0, ',', '.')),
            Stat::make('Saldo Saat Ini', 'Rp '.number_format($balance, 0, ',', '.')),
        ];
    }
}
