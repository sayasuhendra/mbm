<?php

namespace App\Filament\Exports;

use App\Models\ArcheryMaterial;
use Filament\Actions\Exports\ExportColumn;

class ArcheryMaterialExporter extends BaseExporter
{
    protected static ?string $model = ArcheryMaterial::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('title')->label('Judul'),
            ExportColumn::make('content')->label('Materi'),
            ExportColumn::make('is_active')->label('Aktif')->formatStateUsing(fn (bool $state): string => $state ? 'Ya' : 'Tidak'),
            ExportColumn::make('created_at')->label('Dibuat Pada'),
            ExportColumn::make('updated_at')->label('Diperbarui Pada'),
        ];
    }
}
