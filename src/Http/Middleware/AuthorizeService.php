<?php

namespace Ghostscypher\CDP\Http\Middleware;

use Closure;
use Ghostscypher\CDP\Models\Credential;

class AuthorizeService
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!$request->hasHeader('Authorization Bearer')){
            abort(404);
        }

        $authorization = base64_decode($request->headers->get('Authorization Bearer'));
        $authorization = explode(':', $authorization);
        
        if(count($authorization) !== 2){
            abort(404);
        }

        $service = Credential::where([
            'key' => $authorization[0],
            'secret' => $authorization[1],
        ])->with('service')->first();

        if($service === null){
            abort(404);
        }

        if(!app()->has('cdp_service')){
            app()->instance('cdp_service', $service);
        }
        
        return $next($request);
    }
}
