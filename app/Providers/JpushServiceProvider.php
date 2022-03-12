<?php

namespace App\Providers;

use JPush\Client;
use Illuminate\Support\ServiceProvider;

class JpushServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Client::class, function ($app) {
            return new Client(config('services.jpush.app_key'), config('services.jpush.master_secret'));
        });

        $this->app->alias(Client::class, 'jpush');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
