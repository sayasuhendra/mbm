<?php

namespace App\Filament\Exports;

use App\Models\WhatsappBroadcast;
use Filament\Actions\Exports\ExportColumn;

class WhatsappBroadcastExporter extends BaseExporter
{
    protected static ?string $model = WhatsappBroadcast::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('title')->label('Judul'),
            ExportColumn::make('message')->label('Isi Pesan'),
            ExportColumn::make('target')->label('Target'),
            ExportColumn::make('status')->label('Status'),
            ExportColumn::make('scheduled_at')->label('Jadwal Kirim'),
            ExportColumn::make('sent_at')->label('Dikirim Pada'),
            ExportColumn::make('creator.name')->label('Dibuat Oleh'),
            ExportColumn::make('created_at')->label('Dibuat Pada'),
        ];
    }
}
