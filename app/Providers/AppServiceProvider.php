<?php

namespace App\Providers;

use App\Models\Setting;
use App\Services\Whatsapp\FonnteGateway;
use App\Services\Whatsapp\MetaWhatsappGateway;
use App\Services\Whatsapp\MockWhatsappGateway;
use App\Services\Whatsapp\WablasGateway;
use App\Services\Whatsapp\WhatsappGatewayInterface;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(WhatsappGatewayInterface::class, function () {
            // Default to mock if Settings table doesn't exist or setting is missing
            $gateway = 'mock';

            try {
                if (Schema::hasTable('settings')) {
                    $gateway = Setting::value('whatsapp_gateway', 'mock');
                }
            } catch (\Exception $e) {
                // Ignore exceptions during migrate or when DB is unavailable
            }

            return match ($gateway) {
                'fonnte' => new FonnteGateway,
                'wablas' => new WablasGateway,
                'meta' => new MetaWhatsappGateway,
                default => new MockWhatsappGateway,
            };
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Support\Facades\Gate::before(function ($user, $ability) {
            return $user->hasRole('super_admin') ? true : null;
        });

        if (env('APP_ENV') === 'production' || str_contains(env('APP_URL', ''), 'https')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
    }
}
