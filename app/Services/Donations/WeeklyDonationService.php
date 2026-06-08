<?php

namespace App\Services\Donations;

use App\Models\ArcheryParticipant;
use App\Models\WeeklyDonation;
use App\Services\Whatsapp\WhatsappGatewayInterface;
use Illuminate\Support\Carbon;

class WeeklyDonationService
{
    public function __construct(private readonly WhatsappGatewayInterface $whatsapp) {}

    public function generateForWeek(?Carbon $weekStartDate = null): int
    {
        $weekStartDate ??= now()->startOfWeek();
        $created = 0;

        ArcheryParticipant::query()
            ->active()
            ->chunkById(100, function ($participants) use ($weekStartDate, &$created) {
                foreach ($participants as $participant) {
                    $donation = WeeklyDonation::firstOrCreate(
                        [
                            'archery_participant_id' => $participant->id,
                            'week_start_date' => $weekStartDate->toDateString(),
                        ],
                        [
                            'amount' => $participant->weekly_donation_amount,
                            'status' => WeeklyDonation::STATUS_UNPAID,
                        ]
                    );

                    if ($donation->wasRecentlyCreated) {
                        $created++;
                        $this->sendReminder($participant, $donation);
                    }
                }
            });

        return $created;
    }

    public function sendReminder(ArcheryParticipant $participant, WeeklyDonation $donation): void
    {
        $amount = number_format($donation->amount, 0, ',', '.');

        $this->whatsapp->send(
            $participant->parent_whatsapp,
            "Assalamu'alaikum.\n\nPengingat infak latihan panahan minggu ini sebesar Rp {$amount}.\n\nJazakumullahu khairan."
        );
    }
}
