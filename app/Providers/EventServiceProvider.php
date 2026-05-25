<?php

namespace App\Providers;

use App\Listeners\HandleStripeWebhook;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Laravel\Cashier\Events\WebhookHandled;
use App\Listeners\Handlewebhook;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Event::listen(
            WebhookHandled::class,
            HandleStripeWebhook::class
        );
    }
}
