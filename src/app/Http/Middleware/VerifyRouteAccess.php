<?php

namespace LaravelEnso\Core\app\Http\Middleware;

use Closure;

class VerifyRouteAccess
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->user()->hasAccessTo($request->route()->getName())) {
            if ($request->ajax()) {
                return response()->json([
                    'code'    => 401,
                    'level'   => 'warning',
                    'message' => __('You are not authorized for this action'),
                ], 401);
            }

            flash()->warning(__('You are not authorized for this action'));

            return back();
        }

        return $next($request);
    }
}
