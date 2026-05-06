<?php

namespace App\Http\Middleware;
use Closure;
class Authenticate
{
    public function handle($request, Closure $next)
    {
        if (!session()->has('user_id')) {
            return redirect()->route('login')->with('error', 'Please login to access the dashboard.');
        }

        return $next($request);
    }
}