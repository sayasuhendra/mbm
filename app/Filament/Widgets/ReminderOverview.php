<?php

namespace App\Filament\Widgets;

use App\Models\WeeklyDonation;
use App\Models\WhatsappBroadcast;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ReminderOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Tagihan Belum Dibayar', WeeklyDonation::query()->where('status', WeeklyDonation::STATUS_UNPAID)->count()),
            Stat::make('Broadcast Terjadwal', WhatsappBroadcast::query()->where('status', WhatsappBroadcast::STATUS_SCHEDULED)->count()),
        ];
    }
}
