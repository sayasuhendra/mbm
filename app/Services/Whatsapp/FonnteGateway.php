<?php

namespace App\Services\Whatsapp;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class FonnteGateway implements WhatsappGatewayInterface
{
    public function send(string $phoneNumber, string $message): array
    {
        // Placeholder for real HTTP call using Laravel Http Client
        // $response = Http::withHeaders(['Authorization' => 'token'])->post('https://api.fonnte.com/send', [...]);

        Log::info('Fonnte WhatsApp message sent (Simulated).', [
            'to' => $phoneNumber,
            'message' => $message,
        ]);

        return [
            'success' => true,
            'message' => 'Fonnte WhatsApp terkirim (Simulated).',
            'provider_id' => (string) Str::uuid(),
        ];
    }
}
