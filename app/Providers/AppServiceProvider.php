<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use URL;
use function session_save_path;
use function session_status;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */

    public function boot()
    {
        URL::forceSchema('https');
    }

    public function register()
    {
        session_save_path(__DIR__ . "/../../storage/framework/sessions");
        if(session_status() !== PHP_SESSION_ACTIVE)
            session_start();
    }
}
