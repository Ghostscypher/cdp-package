<?php

namespace Ghostscypher\CDP\Http\Middleware;

use Closure;

class CheckServiceStatus extends AbstractExceptMiddleware
{
    public function handleRequest($request, Closure $next)
    {
        // Perform action
        return $next($request);
    }
}