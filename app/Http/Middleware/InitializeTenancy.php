<?php

namespace App\Http\Middleware;

use App\Models\Property;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Response;

class InitializeTenancy
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $host = $request->getHost();

        if ($host == config('app.domain')) {
            return $next($request);
        }

        $parts = explode('.', $host);
        $subdomain = $parts[0];

        $property = Property::whereSubdomain($subdomain)->first();

        if ($property) {
            app()->instance('currentProperty', $property);
            Config::set('app.name', $property->name);
        } 

        return $next($request);
    }
}
