<?php

namespace Kawankoding\Fcm;

use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\ServiceProvider;
use Kawankoding\Fcm\Fcm;
use Laravel\Lumen\Application as LumenApplication;

/**
 * Class FcmServiceProvider
 * @package Kawankoding\Fcm\Providers
 */
class FcmServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../resources/config/laravel-fcm.php' => config_path('laravel-fcm.php'),
            ]);
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('laravel-fcm');
        }
    }

    public function register()
    {
        $this->app->bind('fcm', function ($app) {
            return new Fcm(
                config('laravel-fcm.server_key')
            );
        });
    }
}
