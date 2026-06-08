<?php

namespace App\Filament\Resources\ArcheryParticipants\Pages;

use App\Filament\Resources\ArcheryParticipants\ArcheryParticipantResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListArcheryParticipants extends ListRecords
{
    protected static string $resource = ArcheryParticipantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
