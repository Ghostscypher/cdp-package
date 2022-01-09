<?php

namespace Ghostscypher\CDP\Http\Middleware;

use Closure;
use Ghostscypher\CDP\Facades\CDP;

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
        if(!$request->hasHeader('Authorization')){
            abort(404);
        }

        $authorization =  base64_decode(str_replace(["Bearer", " "], "", $request->headers->get('Authorization')));
        $authorization = explode(':', $authorization);
        
        if(count($authorization) !== 2){
            abort(404);
        }

        $credentials = CDP::credentialModel()->where([
            'key' => $authorization[0],
            'secret' => $authorization[1],
        ])->with('service')->first();

        if($credentials === null || $credentials->service === null){
            abort(404);
        }

        if($credentials->service !== 'active' && !$request->force){
            abort(404);
        }

        if(!app()->has('cdp_credentials')){
            app()->instance('cdp_credentials', $credentials);
        }

        return $next($request);
    }
}
