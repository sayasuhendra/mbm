<?php

namespace App\Filament\Exports;

use App\Models\ArcheryParticipant;
use Filament\Actions\Exports\ExportColumn;

class ArcheryParticipantExporter extends BaseExporter
{
    protected static ?string $model = ArcheryParticipant::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('member_number')->label('Nomor Anggota'),
            ExportColumn::make('parent_name')->label('Nama Orang Tua'),
            ExportColumn::make('parent_whatsapp')->label('WhatsApp Orang Tua'),
            ExportColumn::make('parent_address')->label('Alamat'),
            ExportColumn::make('child_name')->label('Nama Anak'),
            ExportColumn::make('child_age')->label('Usia'),
            ExportColumn::make('child_school_class')->label('Kelas / Sekolah'),
            ExportColumn::make('training_permission')->label('Izin Latihan')->formatStateUsing(fn (bool $state): string => $state ? 'Ya' : 'Tidak'),
            ExportColumn::make('weekly_donation_amount')->label('Infak Mingguan'),
            ExportColumn::make('equipment_option')->label('Pilihan Perlengkapan'),
            ExportColumn::make('equipment_contribution_amount')->label('Kontribusi Perlengkapan'),
            ExportColumn::make('suggestion')->label('Saran'),
            ExportColumn::make('status')->label('Status'),
            ExportColumn::make('registered_at')->label('Tanggal Daftar'),
        ];
    }
}
