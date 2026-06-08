<?php

namespace App\Filament\Resources\WeeklyDonations\Pages;

use App\Filament\Resources\WeeklyDonations\WeeklyDonationResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditWeeklyDonation extends EditRecord
{
    protected static string $resource = WeeklyDonationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
