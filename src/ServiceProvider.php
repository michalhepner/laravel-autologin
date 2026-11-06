<?php

namespace MichalHepner\LaravelAutologin;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/autologin.php', 'autologin');
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/autologin.php' => config_path('autologin.php'),
        ], 'config');
    }
}
