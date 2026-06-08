<?php

namespace App\Jobs;

use App\Models\WhatsappBroadcast;
use App\Services\Whatsapp\WhatsappBroadcastService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendWhatsappBroadcastJob implements ShouldQueue
{
    use Queueable;

    public function __construct(public int $broadcastId) {}

    public function handle(WhatsappBroadcastService $broadcasts): void
    {
        $broadcast = WhatsappBroadcast::findOrFail($this->broadcastId);

        $broadcasts->send($broadcast);
    }
}
