<?php

namespace Ghostscypher\CDP\Http\Middleware;

use Closure;
use Ghostscypher\CDP\Models\Service;

class CheckServiceStatus extends AbstractExceptMiddleware
{
    public function handleRequest($request, Closure $next)
    {
        $host = $request->getHost();

        $service = Service::where('deployment_url', $host)->with('credential')->first();

        if($service){
            app()->instance('cdp_service', $service);
        }

        // Perform action
        return $next($request);
    }
}