<?php

namespace App\Services\Participants;

use App\Models\ArcheryParticipant;
use App\Notifications\ArcheryRegistrationReceivedNotification;
use App\Services\Whatsapp\WhatsappGatewayInterface;
use Illuminate\Support\Facades\DB;

class ArcheryRegistrationService
{
    public function __construct(private readonly WhatsappGatewayInterface $whatsapp) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public function register(array $data): ArcheryParticipant
    {
        return DB::transaction(function () use ($data) {
            $participant = ArcheryParticipant::create([
                ...$data,
                'member_number' => ArcheryParticipant::nextMemberNumber(),
                'status' => ArcheryParticipant::STATUS_PENDING,
                'registered_at' => now(),
            ]);

            $participant->notify(new ArcheryRegistrationReceivedNotification);

            $message = $participant->event_name
                ? "Assalamu'alaikum.\n\nTerima kasih telah mendaftar {$participant->event_name}.\n\nKategori: {$participant->child_school_class}\nJadwal lomba: 1 & 2 Agustus 2026, mulai pukul 07.30.\n\nData pendaftaran telah kami terima dan akan segera diverifikasi panitia."
                : "Assalamu'alaikum.\n\nTerima kasih telah mendaftarkan ananda ke Klub Panahan Remaja Masjid Baitul Muttaqin.\n\nData pendaftaran telah kami terima dan akan segera diverifikasi.";

            $this->whatsapp->send($participant->parent_whatsapp, $message);

            return $participant;
        });
    }
}
