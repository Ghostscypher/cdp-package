<?php

namespace Ghostscypher\CDP;

use Ghostscypher\CDP\Contracts\CDPActionContract;
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
            'middleware' => ['cdp_auth'],
        ];

        $options = array_merge($defaultOptions, $options);

        Route::group($options, function ($router) use ($callback) {
            $callback(new RouteRegistrar($router));
        });
    }

    public function credentialModel(): Model
    {
        return app()->make($this->service()['models']['credential']);
    }

    public function deploymentModel(): Model
    {
        return app()->make($this->service()['models']['deployment']);
    }

    public function logModel(): Model
    {
        return app()->make($this->service()['models']['log']);
    }

    public function serviceModel(): Model
    {
        return app()->make($this->service()['models']['service']);
    }

    public function getTasks(): array
    {
        return $this->service()['tasks'];
    }

    public function type(): string
    {
        return $this->service()['type'];
    }

    public function action($task_name): CDPActionContract
    {
        return app()->make($this->getTasks()[$task_name]['action_class']);
    }

    public function shouldQueue($task_name): bool
    {
        return $this->getTasks()[$task_name]['shoul_dqueue'] ?? config('cdp.should_queue');
    }

}
