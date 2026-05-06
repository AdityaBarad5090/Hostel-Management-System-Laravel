<?php

namespace App\Http\Middleware;

use Closure;

class StudentAuth
{
    public function handle($request, Closure $next)
    {
        if (!session('student_id')) {
            return redirect('/student/login');
        }

        return $next($request); 
    }
}
