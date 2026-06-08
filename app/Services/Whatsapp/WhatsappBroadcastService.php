<?php

namespace App\Services\Whatsapp;

use App\Models\ArcheryParticipant;
use App\Models\BroadcastLog;
use App\Models\WhatsappBroadcast;

class WhatsappBroadcastService
{
    public function __construct(private readonly WhatsappGatewayInterface $gateway) {}

    public function send(WhatsappBroadcast $broadcast): int
    {
        $sent = 0;

        $this->participantsFor($broadcast)
            ->chunkById(100, function ($participants) use ($broadcast, &$sent) {
                foreach ($participants as $participant) {
                    $result = $this->gateway->send($participant->parent_whatsapp, $broadcast->message);

                    BroadcastLog::create([
                        'whatsapp_broadcast_id' => $broadcast->id,
                        'archery_participant_id' => $participant->id,
                        'recipient_name' => $participant->parent_name,
                        'recipient_whatsapp' => $participant->parent_whatsapp,
                        'status' => $result['success'] ? 'sent' : 'failed',
                        'response' => $result['message'],
                        'sent_at' => $result['success'] ? now() : null,
                    ]);

                    if ($result['success']) {
                        $sent++;
                    }
                }
            });

        $broadcast->update([
            'status' => WhatsappBroadcast::STATUS_SENT,
            'sent_at' => now(),
        ]);

        return $sent;
    }

    private function participantsFor(WhatsappBroadcast $broadcast)
    {
        return ArcheryParticipant::query()
            ->when($broadcast->target === WhatsappBroadcast::TARGET_ACTIVE, fn ($query) => $query->where('status', ArcheryParticipant::STATUS_ACTIVE))
            ->when($broadcast->target === WhatsappBroadcast::TARGET_INACTIVE, fn ($query) => $query->where('status', ArcheryParticipant::STATUS_INACTIVE));
    }
}
