<?php

namespace Ghostscypher\CDP;

use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;

class CDP
{
    public function service(): array
    {
        $default_service = config('cdp.default');
        return $this->getService($default_service);
    }

    public function getService(string $service_name): array
    {
        return config("cdp.services.{$service_name}");
    }

    public function routes($callback = null, array $options = [])
    {
        $callback = $callback ?: function ($router) {
            $router->all();
        };

        $defaultOptions = [
            'prefix' => 'cdp',
        ];

        $options = array_merge($defaultOptions, $options);

        Route::group($options, function ($router) use ($callback) {
            $callback(new RouteRegistrar($router));
        });
    }

    public function getCredentialModel(): Model
    {
        return $this->service()['models']['credential']::new();
    }

    public function getDeploymentModel(): Model
    {
        return $this->service()['models']['deployment']::new();
    }

    public function getLogModel(): Model
    {
        return $this->service()['models']['log']::new();
    }

    public function getServiceModel(): Model
    {
        return $this->service()['models']['service']::new();
    }

    public function getTasks(): array
    {
        return $this->service()['tasks'];
    }

    public function type(): string
    {
        return $this->service()['type'];
    }

}
