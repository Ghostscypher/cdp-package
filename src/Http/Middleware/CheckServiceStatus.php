<?php

namespace Ghostscypher\CDP\Middleware;

use Closure;

class CheckServiceStatus extends AbstractExceptMiddleware
{
    public function handleRequest($request, Closure $next)
    {
        // Perform action
        return $next($request);
    }
}