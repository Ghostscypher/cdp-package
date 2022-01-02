<?php

namespace Ghostscypher\CDP;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class CDPServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Facade accessor
        $this->app->bind('CDP', function($app) {
            return new CDP();
        });

        $this->mergeConfigFrom(__DIR__ . '/../config/cdp.php', 'cdp');
    }

    public function boot()
    {
        if($this->app->runningInConsole()){
            $this->publishes([
                __DIR__ . '/../config/cdp.php' => config_path('cdp.php')
            ], 'cdp-config');

            $this->publishes([
                __DIR__ . '/../database/migrations' => database_path('migrations/cdp')
            ], 'cdp-migrations');

            $this->commands([
                \Ghostscypher\CDP\Console\InstallCommand::class,
                \Ghostscypher\CDP\Console\RegisterClientCommand::class,
                \Ghostscypher\CDP\Console\CreateClientCommand::class,
                \Ghostscypher\CDP\Console\DropClientCommand::class,
            ]);
        }

        // Register middleware
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('cdp_auth', \Ghostscypher\CDP\Http\Middleware\AuthorizeService::class);
        $router->aliasMiddleware('cdp_only', \Ghostscypher\CDP\Http\Middleware\CDPOnly::class);


        Str::macro('toAlphaNumeric', function($str){
            return preg_replace("/[^a-zA-Z0-9]+/", "", $str);
        });

        Str::macro('getNumeric', function($str){
            return preg_replace("/[^0-9]+/", "", $str);
        });

        Str::macro('toAlphaNumericUppper', function($str){
            return preg_replace("/[^A-Z]+/", "", $str);
        });

        Str::macro('toAlphaNumericLower', function($str){
            return preg_replace("/[^a-z]+/", "", $str);
        });

    }
}
