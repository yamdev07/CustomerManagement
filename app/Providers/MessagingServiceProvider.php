<?php

namespace App\Providers;

use App\Contracts\MessagingServiceInterface;
use App\Services\InfobipService;
use Illuminate\Support\ServiceProvider;

class MessagingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            MessagingServiceInterface::class,
            function ($app) {
                // Par défaut on utilise Infobip; changer ici selon l'environnement
                // ex: return $app->make(TwilioService::class);
                return $app->make(InfobipService::class);
            }
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
