<?php

namespace Tests\Unit;

use App\Models\Setting;
use App\Services\Whatsapp\FonnteGateway;
use App\Services\Whatsapp\MetaWhatsappGateway;
use App\Services\Whatsapp\MockWhatsappGateway;
use App\Services\Whatsapp\WablasGateway;
use App\Services\Whatsapp\WhatsappGatewayInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WhatsappGatewayResolutionTest extends TestCase
{
    use RefreshDatabase;

    public function test_resolves_mock_gateway_by_default()
    {
        $gateway = app(WhatsappGatewayInterface::class);
        $this->assertInstanceOf(MockWhatsappGateway::class, $gateway);
    }

    public function test_resolves_fonnte_gateway()
    {
        Setting::updateOrCreate(['key' => 'whatsapp_gateway'], ['value' => 'fonnte', 'type' => 'string']);
        
        $gateway = app(WhatsappGatewayInterface::class);
        $this->assertInstanceOf(FonnteGateway::class, $gateway);
    }

    public function test_resolves_wablas_gateway()
    {
        Setting::updateOrCreate(['key' => 'whatsapp_gateway'], ['value' => 'wablas', 'type' => 'string']);
        
        $gateway = app(WhatsappGatewayInterface::class);
        $this->assertInstanceOf(WablasGateway::class, $gateway);
    }

    public function test_resolves_meta_gateway()
    {
        Setting::updateOrCreate(['key' => 'whatsapp_gateway'], ['value' => 'meta', 'type' => 'string']);
        
        $gateway = app(WhatsappGatewayInterface::class);
        $this->assertInstanceOf(MetaWhatsappGateway::class, $gateway);
    }
}
