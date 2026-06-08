<?php

namespace App\Filament\Resources\ArcheryParticipants\Pages;

use App\Filament\Resources\ArcheryParticipants\ArcheryParticipantResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditArcheryParticipant extends EditRecord
{
    protected static string $resource = ArcheryParticipantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
