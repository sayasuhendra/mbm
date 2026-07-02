<?php

namespace Tests\Feature;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Income;
use App\Models\IncomeCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use OpenSpout\Reader\XLSX\Reader;
use Tests\TestCase;

class PublicFinancialReportTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_financial_report_is_accessible(): void
    {
        $incomeCategory = IncomeCategory::create(['name' => 'Infak Panahan']);
        $expenseCategory = ExpenseCategory::create(['name' => 'Peralatan']);

        Income::create([
            'date' => now()->toDateString(),
            'income_category_id' => $incomeCategory->id,
            'source' => 'Infak latihan',
            'amount' => 100000,
        ]);

        Expense::create([
            'date' => now()->toDateString(),
            'expense_category_id' => $expenseCategory->id,
            'amount' => 25000,
            'description' => 'Target face',
        ]);

        $this->get(route('financial-report.public'))
            ->assertOk()
            ->assertSee('Laporan Keuangan Publik')
            ->assertSee('Rp 100.000')
            ->assertSee('Rp 25.000');
    }

    public function test_public_financial_report_can_be_exported_as_balance_sheet_excel(): void
    {
        $incomeCategory = IncomeCategory::create(['name' => 'Infak Panahan']);
        $expenseCategory = ExpenseCategory::create(['name' => 'Peralatan']);

        Income::create([
            'date' => '2026-07-01',
            'income_category_id' => $incomeCategory->id,
            'source' => 'Infak latihan',
            'amount' => 100000,
        ]);

        Expense::create([
            'date' => '2026-07-02',
            'expense_category_id' => $expenseCategory->id,
            'amount' => 25000,
            'description' => 'Target face',
        ]);

        $response = $this->get(route('financial-report.export-excel', [
            'year' => 2026,
            'month' => 7,
        ]));

        $response->assertOk()->assertDownload('laporan-keuangan-2026-07.xlsx');

        $reader = new Reader;
        $reader->open($response->baseResponse->getFile()->getPathname());
        $rows = [];

        foreach ($reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $row) {
                $rows[] = $row->toArray();
            }
        }

        $reader->close();

        $this->assertSame(['No', 'Pemasukan', 'Pengeluaran', 'Saldo'], $rows[2]);
        $this->assertSame([1, 100000, '', 100000], $rows[3]);
        $this->assertSame([2, '', 25000, 75000], $rows[4]);
        $this->assertSame(['TOTAL', 100000, 25000, 75000], $rows[5]);
    }
}
