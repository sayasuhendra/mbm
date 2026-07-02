<?php

namespace App\Filament\Exports;

use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

abstract class BaseExporter extends Exporter
{
    public function getJobConnection(): ?string
    {
        return config('filament-export.queue_connection', 'sync');
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Export Excel selesai. '.Number::format($export->successful_rows).' baris berhasil diekspor.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' '.Number::format($failedRowsCount).' baris gagal diekspor.';
        }

        return $body;
    }
}
