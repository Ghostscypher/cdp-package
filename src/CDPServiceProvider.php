<?php

namespace Ghostscypher\CDP;

use Ghostscypher\CDP\Console\CreateClientCommand;
use Ghostscypher\CDP\Console\InstallCommand;
use Ghostscypher\CDP\Console\RegisterClientCommand;
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
                __DIR__ . '/../database/migrations/' => database_path('migrations')
            ], 'cdp-migrations');

            $this->commands([
                InstallCommand::class,
                RegisterClientCommand::class,
                CreateClientCommand::class,
            ]);
        }
    }
}
