<?php

namespace App\Filament\Resources\ArcheryMaterials\Pages;

use App\Filament\Resources\ArcheryMaterials\ArcheryMaterialResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListArcheryMaterials extends ListRecords
{
    protected static string $resource = ArcheryMaterialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
