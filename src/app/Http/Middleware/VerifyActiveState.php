<?php

namespace LaravelEnso\Core\app\Http\Middleware;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;

class VerifyActiveState
{
    public function handle($request, Closure $next)
    {
        if ($request->user()->isDisabled()) {
            auth()->logout();

            throw new AuthorizationException(__(config('enso.labels.disabledAccount')), 401);
        }

        return $next($request);
    }
}
