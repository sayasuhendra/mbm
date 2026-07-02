<?php

namespace App\Filament\Resources\ArcheryParticipants\Pages;

use App\Filament\Exports\ArcheryParticipantExporter;
use App\Filament\Resources\ArcheryParticipants\ArcheryParticipantResource;
use Filament\Actions\CreateAction;
use Filament\Actions\ExportAction;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Resources\Pages\ListRecords;

class ListArcheryParticipants extends ListRecords
{
    protected static string $resource = ArcheryParticipantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::make('exportExcel')
                ->label('Export ke Excel')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->exporter(ArcheryParticipantExporter::class)
                ->columnMapping(false)
                ->formats([ExportFormat::Xlsx]),
            CreateAction::make(),
        ];
    }
}
