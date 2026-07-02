<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Income;
use App\Services\Finance\BalanceSheetExcelService;
use App\Services\Finance\FinancialReportService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PublicFinancialReportController extends Controller
{
    public function __invoke(Request $request, FinancialReportService $reports): View
    {
        $year = (int) $request->integer('year', now()->year);
        $month = $request->integer('month') ?: null;

        $incomeQuery = Income::query()->with('category')->latest('date');
        $expenseQuery = Expense::query()->with('category')->latest('date');

        foreach ([$incomeQuery, $expenseQuery] as $query) {
            $query->whereYear('date', $year);

            if ($month) {
                $query->whereMonth('date', $month);
            }
        }

        return view('public.financial-report', [
            'summary' => $reports->summary(),
            'cashflow' => $reports->monthlyCashflow($year),
            'incomes' => $incomeQuery->get(),
            'expenses' => $expenseQuery->get(),
            'year' => $year,
            'month' => $month,
        ]);
    }

    public function export(Request $request, BalanceSheetExcelService $excel): BinaryFileResponse
    {
        $validated = $request->validate([
            'year' => ['nullable', 'integer', 'min:2000', 'max:2100'],
            'month' => ['nullable', 'integer', 'between:1,12'],
        ]);

        return $excel->download(
            (int) ($validated['year'] ?? now()->year),
            isset($validated['month']) ? (int) $validated['month'] : null,
        );
    }
}
