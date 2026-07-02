<?php

namespace App\Services\Finance;

use App\Models\Expense;
use App\Models\Income;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Common\Entity\Style\CellAlignment;
use OpenSpout\Common\Entity\Style\Color;
use OpenSpout\Common\Entity\Style\Style;
use OpenSpout\Writer\XLSX\Options;
use OpenSpout\Writer\XLSX\Writer;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class BalanceSheetExcelService
{
    public function download(int $year, ?int $month = null): BinaryFileResponse
    {
        $temporaryFile = tempnam(sys_get_temp_dir(), 'mbm-balance-sheet-');
        $options = new Options;
        $options->setColumnWidth(8, 1);
        $options->setColumnWidth(22, 2, 3, 4);

        $writer = new Writer($options);
        $writer->openToFile($temporaryFile);
        $writer->getCurrentSheet()->setName('Laporan Keuangan');

        $titleStyle = (new Style)
            ->setFontBold()
            ->setFontSize(16)
            ->setFontColor(Color::WHITE)
            ->setBackgroundColor('065F46')
            ->setCellAlignment(CellAlignment::CENTER);

        $headerStyle = (new Style)
            ->setFontBold()
            ->setFontColor(Color::WHITE)
            ->setBackgroundColor('047857')
            ->setCellAlignment(CellAlignment::CENTER);

        $currencyStyle = (new Style)
            ->setFormat('Rp #,##0')
            ->setCellAlignment(CellAlignment::RIGHT);

        $totalStyle = (new Style)
            ->setFontBold()
            ->setBackgroundColor('D1FAE5')
            ->setFormat('Rp #,##0');

        $writer->addRow(Row::fromValues(['LAPORAN KEUANGAN BAITUL MUTTAQIN YOUTH', null, null, null], $titleStyle));
        $writer->addRow(Row::fromValues([$this->periodLabel($year, $month), null, null, null]));
        $writer->addRow(Row::fromValues([]));
        $writer->addRow(Row::fromValues(['No', 'Pemasukan', 'Pengeluaran', 'Saldo'], $headerStyle));

        $balance = 0;
        $totalIncome = 0;
        $totalExpense = 0;

        foreach ($this->transactions($year, $month) as $index => $transaction) {
            $income = $transaction['type'] === 'income' ? $transaction['amount'] : null;
            $expense = $transaction['type'] === 'expense' ? $transaction['amount'] : null;
            $balance += ($income ?? 0) - ($expense ?? 0);
            $totalIncome += $income ?? 0;
            $totalExpense += $expense ?? 0;

            $writer->addRow(Row::fromValuesWithStyles(
                [$index + 1, $income, $expense, $balance],
                null,
                [1 => $currencyStyle, 2 => $currencyStyle, 3 => $currencyStyle],
            ));
        }

        $writer->addRow(Row::fromValuesWithStyles(
            ['TOTAL', $totalIncome, $totalExpense, $balance],
            $totalStyle,
            [1 => $currencyStyle, 2 => $currencyStyle, 3 => $currencyStyle],
        ));

        $writer->close();

        $period = $month ? sprintf('%04d-%02d', $year, $month) : (string) $year;

        return response()
            ->download(
                $temporaryFile,
                "laporan-keuangan-{$period}.xlsx",
                ['Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'],
            )
            ->deleteFileAfterSend(true);
    }

    /**
     * @return array<int, array{type: string, amount: int, date: string, id: int}>
     */
    private function transactions(int $year, ?int $month): array
    {
        $incomes = Income::query()
            ->whereYear('date', $year)
            ->when($month, fn ($query) => $query->whereMonth('date', $month))
            ->get(['id', 'date', 'amount'])
            ->map(fn (Income $income): array => [
                'type' => 'income',
                'amount' => (int) $income->amount,
                'date' => $income->date->format('Y-m-d'),
                'id' => $income->id,
            ]);

        $expenses = Expense::query()
            ->whereYear('date', $year)
            ->when($month, fn ($query) => $query->whereMonth('date', $month))
            ->get(['id', 'date', 'amount'])
            ->map(fn (Expense $expense): array => [
                'type' => 'expense',
                'amount' => (int) $expense->amount,
                'date' => $expense->date->format('Y-m-d'),
                'id' => $expense->id,
            ]);

        return $incomes
            ->concat($expenses)
            ->sortBy(fn (array $transaction): string => $transaction['date'].'-'.$transaction['id'].'-'.$transaction['type'])
            ->values()
            ->all();
    }

    private function periodLabel(int $year, ?int $month): string
    {
        if (! $month) {
            return "Periode Tahun {$year}";
        }

        $monthName = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ][$month];

        return "Periode {$monthName} {$year}";
    }
}
