<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class ArcheryRegistrationReceivedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        if ($notifiable->event_name) {
            return [
                'title' => 'Pendaftaran lomba diterima',
                'message' => 'Data pendaftaran '.$notifiable->event_name.' telah diterima dan menunggu verifikasi.',
            ];
        }

        return [
            'title' => 'Pendaftaran panahan diterima',
            'message' => 'Data pendaftaran ananda telah diterima dan menunggu verifikasi.',
        ];
    }
}
