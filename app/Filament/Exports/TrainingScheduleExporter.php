<?php

namespace App\Filament\Exports;

use App\Models\TrainingSchedule;
use Filament\Actions\Exports\ExportColumn;

class TrainingScheduleExporter extends BaseExporter
{
    protected static ?string $model = TrainingSchedule::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('title')->label('Judul'),
            ExportColumn::make('day_of_week')->label('Hari')->formatStateUsing(fn (int $state): string => ['Ahad', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'][$state] ?? 'Tidak diketahui'),
            ExportColumn::make('starts_at')->label('Mulai'),
            ExportColumn::make('ends_at')->label('Selesai'),
            ExportColumn::make('location')->label('Lokasi'),
            ExportColumn::make('description')->label('Deskripsi'),
            ExportColumn::make('is_active')->label('Aktif')->formatStateUsing(fn (bool $state): string => $state ? 'Ya' : 'Tidak'),
        ];
    }
}
