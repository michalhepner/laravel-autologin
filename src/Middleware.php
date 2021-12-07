<?php

namespace MichalHepner\LaravelAutologin;

use Closure;
use Illuminate\Http\Request;

class Middleware
{
    public function handle(Request $request, Closure $next)
    {
        $handler = $this->getHandler();
        $config = $this->getConfig();

        if ($handler->handle($config)) {
            if ($redirect = config('autologin.redirect')) {
                return redirect($redirect);
            }
        }

        return $next($request);
    }

    protected function getHandler(): Handler
    {
        $handlerClass = config(sprintf('autologin.handlers.%s.class', config('autologin.handler')));

        return app()->make($handlerClass);
    }

    protected function getConfig(): array
    {
        return config(sprintf('autologin.handlers.%s.config', config('autologin.handler')), []);
    }
}
