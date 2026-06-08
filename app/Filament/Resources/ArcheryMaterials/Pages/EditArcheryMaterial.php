<?php

namespace App\Filament\Resources\ArcheryMaterials\Pages;

use App\Filament\Resources\ArcheryMaterials\ArcheryMaterialResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditArcheryMaterial extends EditRecord
{
    protected static string $resource = ArcheryMaterialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
