<?php

namespace Tests\Feature;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Income;
use App\Models\IncomeCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
}
