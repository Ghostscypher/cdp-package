<?php

namespace Ghostscypher\CDP;

use Illuminate\Support\Facades\Route;

class CDP
{
    public function routes($callback = null, array $options = [])
    {
        $callback = $callback ?: function ($router) {
            $router->all();
        };

        $defaultOptions = [
            'prefix' => 'cdp',
            'namespace' => '\Ghostscypher\CDP\Http\Controllers',
        ];

        $options = array_merge($defaultOptions, $options);

        Route::group($options, function ($router) use ($callback) {
            $callback(new RouteRegistrar($router));
        });
    }

}
