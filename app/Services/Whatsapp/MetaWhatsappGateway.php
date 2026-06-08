<?php

namespace App\Services\Whatsapp;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class MetaWhatsappGateway implements WhatsappGatewayInterface
{
    public function send(string $phoneNumber, string $message): array
    {
        // Placeholder for real HTTP call
        // $response = Http::withToken('token')->post('https://graph.facebook.com/v17.0/PHONE_NUMBER_ID/messages', [...]);

        Log::info('Meta WhatsApp message sent (Simulated).', [
            'to' => $phoneNumber,
            'message' => $message,
        ]);

        return [
            'success' => true,
            'message' => 'Meta WhatsApp terkirim (Simulated).',
            'provider_id' => (string) Str::uuid(),
        ];
    }
}
