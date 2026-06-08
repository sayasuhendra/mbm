<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class WeeklyDonationReminderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public int $amount) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Pengingat infak mingguan',
            'message' => 'Tagihan infak minggu ini sebesar Rp '.number_format($this->amount, 0, ',', '.'),
        ];
    }
}
