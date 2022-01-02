<?php

namespace Ghostscypher\CDP;

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
            ->group(['middleware' => 'cdp_auth'], function($router){
                $router->get('tasks', [TaskController::class, 'getTasks'])->name('cdp.tasks.index');
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