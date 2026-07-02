<?php

namespace App\Filament\Exports;

use App\Models\Gallery;
use Filament\Actions\Exports\ExportColumn;

class GalleryExporter extends BaseExporter
{
    protected static ?string $model = Gallery::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('title')->label('Judul'),
            ExportColumn::make('description')->label('Deskripsi'),
            ExportColumn::make('is_active')->label('Tampil')->formatStateUsing(fn (bool $state): string => $state ? 'Ya' : 'Tidak'),
            ExportColumn::make('created_at')->label('Dibuat Pada'),
            ExportColumn::make('updated_at')->label('Diperbarui Pada'),
        ];
    }
}
