<?php

namespace App\Http\Middleware;

use App\Agency;
use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;
class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->permission_id) {
            if (Auth::user()->can(\Request()->route()->getActionMethod(), [User::class, Request()->route()->getController()::NAME]) || Request()->route()->getController()::NAME == 'Dashboard') {
                return $next($request);
            } else {
                abort(403);
            }
        } else {
            abort(404);
        }
    }
}
