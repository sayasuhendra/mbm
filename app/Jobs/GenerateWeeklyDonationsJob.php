<?php

namespace App\Jobs;

use App\Services\Donations\WeeklyDonationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class GenerateWeeklyDonationsJob implements ShouldQueue
{
    use Queueable;

    public function __construct(public ?string $weekStartDate = null) {}

    public function handle(WeeklyDonationService $donations): void
    {
        $donations->generateForWeek($this->weekStartDate ? now()->parse($this->weekStartDate) : null);
    }
}
