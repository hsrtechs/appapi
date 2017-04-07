<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use function session_status;
use URL;

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
        if(session_status() !== PHP_SESSION_ACTIVE)
            session_start();
    }
}
