<?php

namespace Erjon\LaravelLicense\Http\Middleware;

use Closure;
use Erjon\LaravelLicense\Facades\License;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ActiveLicense
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(License::isActivated()) {
            return $next($request);
        }

        return redirect()->route('license.activate');
    }
}
