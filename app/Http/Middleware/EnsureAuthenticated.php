<?php

namespace App\Http\Middleware;

use App\Services\PatreonService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAuthenticated
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

        return $next($request);
    }
}
