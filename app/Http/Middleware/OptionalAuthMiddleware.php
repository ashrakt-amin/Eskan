<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OptionalAuthMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!$request->user() && !$request->bearerToken()) {
            return $next($request);
        }

        return response('Unauthorized.', 401);
    }
}
