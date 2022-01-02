<?php

namespace Ghostscypher\CDP;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

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

    }
}
