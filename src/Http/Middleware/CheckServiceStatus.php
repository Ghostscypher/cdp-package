<?php

namespace Ghostscypher\CDP\Http\Middleware;

use Closure;
use Ghostscypher\CDP\Facades\CDP;
use Ghostscypher\CDP\Models\Service;

class CheckServiceStatus extends AbstractExceptMiddleware
{
    protected $except = [
        'cdp/*'
    ];

    public function handleRequest($request, Closure $next)
    {
        $host = $request->getHost();

        $service = Service::where('deployment_url', $host)->with('credential')->first();

        if($service && $service->type === 'client'){
            $action = CDP::action($service->status);

            if($action->authorize()){
                abort(503, 'Service unavailabe');
            }

            app()->instance('cdp_service', $service);
        }

        // Perform action
        return $next($request);
    }
}