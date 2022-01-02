<?php

namespace Ghostscypher\CDP\Http\Middleware;

use Closure;
use Ghostscypher\CDP\Facades\CDP;

class CDPOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, string $only)
    {
        $only = explode(",", strtolower(str_replace(" ", "", $only)));

        if(!app()->has('cdp_credentials') || !in_array(CDP::type(), $only)){
            abort(404);
        }

        return $next($request);
    }
}
