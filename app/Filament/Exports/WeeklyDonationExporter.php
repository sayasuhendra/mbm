<?php

namespace App\Filament\Exports;

use App\Models\WeeklyDonation;
use Filament\Actions\Exports\ExportColumn;

class WeeklyDonationExporter extends BaseExporter
{
    protected static ?string $model = WeeklyDonation::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('participant.member_number')->label('Nomor Anggota'),
            ExportColumn::make('participant.child_name')->label('Peserta'),
            ExportColumn::make('week_start_date')->label('Awal Pekan'),
            ExportColumn::make('amount')->label('Nominal'),
            ExportColumn::make('status')->label('Status')->formatStateUsing(fn (string $state): string => $state === WeeklyDonation::STATUS_PAID ? 'Sudah Dibayar' : 'Belum Dibayar'),
            ExportColumn::make('paid_at')->label('Dibayar Pada'),
            ExportColumn::make('notes')->label('Catatan'),
        ];
    }
}
