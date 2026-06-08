<?php

namespace App\Filament\Widgets;

use App\Services\Finance\FinancialReportService;
use Filament\Widgets\ChartWidget;

class CashflowChart extends ChartWidget
{
    protected ?string $heading = 'Cashflow Bulanan';

    protected function getData(): array
    {
        $cashflow = app(FinancialReportService::class)->monthlyCashflow((int) now()->year);

        return [
            'datasets' => [
                [
                    'label' => 'Pemasukan',
                    'data' => array_column($cashflow, 'income'),
                    'borderColor' => '#047857',
                    'backgroundColor' => '#047857',
                ],
                [
                    'label' => 'Pengeluaran',
                    'data' => array_column($cashflow, 'expense'),
                    'borderColor' => '#b91c1c',
                    'backgroundColor' => '#b91c1c',
                ],
            ],
            'labels' => array_column($cashflow, 'month'),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
