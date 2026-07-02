<?php

namespace App\Filament\Exports;

use App\Models\Setting;
use Filament\Actions\Exports\ExportColumn;

class SettingExporter extends BaseExporter
{
    protected static ?string $model = Setting::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('key')->label('Kunci'),
            ExportColumn::make('value')->label('Nilai'),
            ExportColumn::make('type')->label('Tipe'),
            ExportColumn::make('group')->label('Grup'),
            ExportColumn::make('updated_at')->label('Diperbarui Pada'),
        ];
    }
}
