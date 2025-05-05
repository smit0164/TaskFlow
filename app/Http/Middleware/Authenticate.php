<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->guest()) {
            if ($guard === 'admin') {
                return redirect()->route('admin.login');
            } else if ($guard === 'intern') {
                return redirect()->route('intern.login');
            } 
        }

        return $next($request);
    }
}
