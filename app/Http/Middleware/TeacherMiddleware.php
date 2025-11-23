<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TeacherMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->role === 'guru') {
            return $next($request);
        }

        // Redirect ke dashboard siswa jika bukan guru
        return redirect()->route('dashboard')->with('error', 'Akses hanya untuk guru.');
    }
}