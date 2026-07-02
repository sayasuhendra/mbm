<?php

namespace App\Filament\Exports;

use App\Models\Expense;
use Filament\Actions\Exports\ExportColumn;

class ExpenseExporter extends BaseExporter
{
    protected static ?string $model = Expense::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('date')->label('Tanggal'),
            ExportColumn::make('category.name')->label('Kategori'),
            ExportColumn::make('amount')->label('Nominal'),
            ExportColumn::make('description')->label('Keterangan'),
            ExportColumn::make('creator.name')->label('Dicatat Oleh'),
            ExportColumn::make('created_at')->label('Dibuat Pada'),
        ];
    }
}
