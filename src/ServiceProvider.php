<?php

namespace MichalHepner\LaravelAutologin;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/autologin.php' => config_path('autologin.php'),
        ], 'config');
    }
}
