<?php

namespace App\Http\Middleware;

use App\Services\PatreonService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePledged
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!PatreonService::hasAuthenticated()) {
            return redirect('/auth/redirect');
        }
        
        if (!PatreonService::hasPledged()) {
            return redirect('/')->with('error', 'You must be an active patron to access this page.');
        }

        return $next($request);
    }
}
