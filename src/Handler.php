<?php

namespace MichalHepner\LaravelAutologin;

use Illuminate\Contracts\Auth\Authenticatable;

interface Handler
{
    public function handle(array $config): ?Authenticatable;
}
