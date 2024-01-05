<?php

// app/Http/Middleware/EnsureUserIsAdmin.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsTeacher
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->roles === 'teacher') {
            return $next($request);
        }

        // Redirect or throw an error if user is not an admin
        return redirect('home')->with('error', 'You do not have access to this section');
    }
}


