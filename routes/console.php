<?php

use App\Jobs\GenerateWeeklyDonationsJob;
use App\Jobs\SendWhatsappBroadcastJob;
use App\Models\WhatsappBroadcast;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::job(new GenerateWeeklyDonationsJob)
    ->weeklyOn(1, '07:00')
    ->name('generate-weekly-archery-donations')
    ->withoutOverlapping();

Schedule::call(function () {
    WhatsappBroadcast::query()
        ->where('status', WhatsappBroadcast::STATUS_SCHEDULED)
        ->whereNotNull('scheduled_at')
        ->where('scheduled_at', '<=', now())
        ->each(fn (WhatsappBroadcast $broadcast) => SendWhatsappBroadcastJob::dispatch($broadcast->id));
})
    ->everyMinute()
    ->name('dispatch-scheduled-whatsapp-broadcasts')
    ->withoutOverlapping();
