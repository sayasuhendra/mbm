<?php

namespace App\Services\Whatsapp;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class MockWhatsappGateway implements WhatsappGatewayInterface
{
    public function send(string $phoneNumber, string $message): array
    {
        Log::info('Mock WhatsApp message sent.', [
            'to' => $phoneNumber,
            'message' => $message,
        ]);

        return [
            'success' => true,
            'message' => 'Mock WhatsApp terkirim.',
            'provider_id' => (string) Str::uuid(),
        ];
    }
}
