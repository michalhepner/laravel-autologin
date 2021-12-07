<?php

namespace MichalHepner\LaravelAutologin;

use Illuminate\Contracts\Auth\Authenticatable;

class NullHandler implements Handler
{
    public function handle(array $config): ?Authenticatable
    {
        return null;
    }
}
