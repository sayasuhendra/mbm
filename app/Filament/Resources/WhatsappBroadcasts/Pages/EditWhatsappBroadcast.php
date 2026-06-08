<?php

namespace App\Filament\Resources\WhatsappBroadcasts\Pages;

use App\Filament\Resources\WhatsappBroadcasts\WhatsappBroadcastResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditWhatsappBroadcast extends EditRecord
{
    protected static string $resource = WhatsappBroadcastResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
