<?php

use MichalHepner\LaravelAutologin\DefaultHandler;
use Michalhepner\LaravelAutologin\NullHandler;

return [
    'redirect' => env('AUTOLOGIN_REDIRECT'),
    'handler' => env('AUTOLOGIN_HANDLER', 'default'),
    'handlers' => [
        'default' => [
            'class' => DefaultHandler::class,
            'config' => [
                'id' => env('AUTOLOGIN_USER_ID'),
            ],
        ],
        'null' => [
            'class' => NullHandler::class,
        ],
    ],
];
