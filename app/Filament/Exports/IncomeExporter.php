<?php

namespace App\Filament\Exports;

use App\Models\Income;
use Filament\Actions\Exports\ExportColumn;

class IncomeExporter extends BaseExporter
{
    protected static ?string $model = Income::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('date')->label('Tanggal'),
            ExportColumn::make('category.name')->label('Kategori'),
            ExportColumn::make('source')->label('Sumber'),
            ExportColumn::make('amount')->label('Nominal'),
            ExportColumn::make('description')->label('Keterangan'),
            ExportColumn::make('creator.name')->label('Dicatat Oleh'),
            ExportColumn::make('created_at')->label('Dibuat Pada'),
        ];
    }
}
