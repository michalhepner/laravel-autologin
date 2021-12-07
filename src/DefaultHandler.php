<?php

namespace MichalHepner\LaravelAutologin;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;

class DefaultHandler implements Handler
{
    public function handle(array $config): ?Authenticatable
    {
        if ($config['id']) {
            return Auth::check() ? null : Auth::loginUsingId(config('id'));
        }

        return null;
    }
}