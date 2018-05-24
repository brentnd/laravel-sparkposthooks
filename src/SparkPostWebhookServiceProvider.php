<?php

namespace Brentnd\Api\Webhooks;

use Illuminate\Support\ServiceProvider;

class SparkPostWebhookServiceProvider extends ServiceProvider
{
    /**
    * Bootstrap the application events.
    *
    * @return void
    */
    public function boot()
    {
        $this->publishes([__DIR__ . '/config/config.php' => config_path('sparkpost-webhooks.php')]);
    }

    /**
    * Register the service provider.
    *
    * @return void
    */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/config.php', 'sparkpost-webhooks');
    }
}
