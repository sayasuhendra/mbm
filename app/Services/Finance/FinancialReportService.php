<?php

namespace App\Services\Finance;

use App\Models\Expense;
use App\Models\Income;
use Illuminate\Support\Carbon;

class FinancialReportService
{
    /**
     * @return array{income: int, expense: int, balance: int}
     */
    public function summary(?Carbon $start = null, ?Carbon $end = null): array
    {
        $income = (int) Income::query()
            ->when($start, fn ($query) => $query->whereDate('date', '>=', $start))
            ->when($end, fn ($query) => $query->whereDate('date', '<=', $end))
            ->sum('amount');

        $expense = (int) Expense::query()
            ->when($start, fn ($query) => $query->whereDate('date', '>=', $start))
            ->when($end, fn ($query) => $query->whereDate('date', '<=', $end))
            ->sum('amount');

        return [
            'income' => $income,
            'expense' => $expense,
            'balance' => $income - $expense,
        ];
    }

    /**
     * @return array<int, array{month: string, income: int, expense: int}>
     */
    public function monthlyCashflow(int $year): array
    {
        return collect(range(1, 12))->map(function (int $month) use ($year) {
            $start = Carbon::create($year, $month)->startOfMonth();
            $end = $start->copy()->endOfMonth();

            return [
                'month' => $start->translatedFormat('M'),
                ...$this->summary($start, $end),
            ];
        })->all();
    }
}
