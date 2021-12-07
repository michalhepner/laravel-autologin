<?php

namespace MichalHepner\LaravelAutologin;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DefaultHandler implements Handler
{
    public function handle(array $config): ?Authenticatable
    {
        $id = $config['id'];
        if ($id && !Auth::check()) {
            /** @var Authenticatable|bool $user */
            $user = Auth::loginUsingId($id);
            if ($user === false) {
                Log::warning(sprintf('Failed to autologin with user id \'%s\'', $id));

                return null;
            }

            return $user;
        }

        return null;
    }
}
