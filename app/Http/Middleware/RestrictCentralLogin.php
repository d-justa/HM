<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class RestrictCentralLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $host = $request->getHost();
        if ($host != config('app.domain')) {
            return $next($request);
        }

        if (Auth::check() && !Auth::user()->hasRole('super-admin')) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            throw ValidationException::withMessages([
                'email' => ['This account does not have permission to access the central portal.'],
            ]);
        }

        return $next($request);
    }
}
