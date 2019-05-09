<?php

namespace Kawankoding\Fcm;

use Illuminate\Support\ServiceProvider;
use Kawankoding\Fcm\Fcm;

/**
 * Class FcmServiceProvider
 * @package Kawankoding\Fcm\Providers
 */
class FcmServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../resources/config/laravel-fcm.php' => config_path('laravel-fcm.php'),
        ]);
    }

    public function register()
    {
        $this->app->singleton('fcm', function ($app) {
            return new Fcm();
        });
    }
}
