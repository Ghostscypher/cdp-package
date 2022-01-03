<?php

namespace Ghostscypher\CDP\Http\Middleware;

use Closure;
use Ghostscypher\CDP\Facades\CDP;

class CheckServiceStatus extends AbstractExceptMiddleware
{
    protected $except = [
        'cdp/*'
    ];

    public function handleRequest($request, Closure $next)
    {
        $host = $request->getHost();

        $service = CDP::serviceModel()->where('deployment_url', $host)->with('credential')->first();

        if($service && $service->type === 'service'){
            $action = CDP::action($service->status);

            if(!$action->authorize()){
                abort(503, 'Service unavailabe');
            }

            app()->instance('cdp_service', $service);
        }

        // Perform action
        return $next($request);
    }
}