<?php

namespace App\Filament\Resources\WeeklyDonations\Pages;

use App\Filament\Resources\WeeklyDonations\WeeklyDonationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListWeeklyDonations extends ListRecords
{
    protected static string $resource = WeeklyDonationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
