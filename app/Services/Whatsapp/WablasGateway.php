<?php

namespace App\Services\Whatsapp;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class WablasGateway implements WhatsappGatewayInterface
{
    public function send(string $phoneNumber, string $message): array
    {
        // Placeholder for real HTTP call
        // $response = Http::withHeaders(['Authorization' => 'token'])->post('https://solo.wablas.com/api/send-message', [...]);

        Log::info('Wablas WhatsApp message sent (Simulated).', [
            'to' => $phoneNumber,
            'message' => $message,
        ]);

        return [
            'success' => true,
            'message' => 'Wablas WhatsApp terkirim (Simulated).',
            'provider_id' => (string) Str::uuid(),
        ];
    }
}
