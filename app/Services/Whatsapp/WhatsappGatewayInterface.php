<?php

namespace App\Services\Whatsapp;

interface WhatsappGatewayInterface
{
    /**
     * @return array{success: bool, message: string, provider_id?: string}
     */
    public function send(string $phoneNumber, string $message): array;
}
