<?php

namespace Ghostscypher\CDP;

use Ghostscypher\CDP\Http\Controllers\LogController;
use Ghostscypher\CDP\Http\Controllers\TaskController;
use Illuminate\Contracts\Routing\Registrar as Router;

class RouteRegistrar
{
     /**
     * The router implementation.
     *
     * @var \Illuminate\Contracts\Routing\Registrar
     */
    protected $router;

    /**
     * Create a new route registrar instance.
     *
     * @param  \Illuminate\Contracts\Routing\Registrar  $router
     * @return void
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * Register routes for transient tokens, clients, and personal access tokens.
     *
     * @return void
     */
    public function all()
    {
        $this->forDeployment();
        $this->forClientToMain();
        $this->forMainToClient();
    }

    /**
     * Register the routes needed for authorization.
     *
     * @return void
     */
    public function forDeployment()
    {
        $this->router
            ->group(['middleware' => 'cdp_only:client'], function($router){
                $router->get('tasks', [TaskController::class, 'getTasks'])->name('cdp.tasks.index');
                $router->get('tasks/{task_name}', [TaskController::class, 'getTask'])->name('cdp.task.index');
                $router->get('tasks/{task_name}/execute', [TaskController::class, 'executeTask'])->name('cdp.task.exceute');
                
                $router->get('logs/{type?}', [LogController::class, 'getLogs'])->name('cdp.logs.index');
                $router->get('logs/{service_uuid}/{type?}', [LogController::class, 'getServiceLogs'])->name('cdp.logs.index');
            });
    }

    /**
     * Register the routes needed for communication from client to parent server.
     *
     * @return void
     */
    public function forClientToMain()
    {

    }

    /**
     * Register the routes needed for communication from parent server to client.
     *
     * @return void
     */
    public function forMainToClient()
    {

    }

}