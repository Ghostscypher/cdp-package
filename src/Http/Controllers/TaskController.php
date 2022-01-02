<?php

namespace Ghostscypher\CDP\Http\Controllers;

use Ghostscypher\CDP\Jobs\UsesClosureJob;
use Ghostscypher\CDP\Http\Resources\ApiResource;
use Ghostscypher\CDP\Facades\CDP;
use Ghostscypher\CDP\Jobs\ExecuteActionJob;

class TaskController
{
    /**
     * @return ApiResource list of API tasks
     */
    public function getTasks()
    {
        if(CDP::type() !== 'client')
        {
            abort(404);
        }

        return response()->json([
            'data' => array_keys(CDP::getTasks()),
            'success' => true,
        ]);
    }
    
    public function getTask(string $task_name)
    {
        $action = CDP::action($task_name);

        return response()->json([
            'data' => [
                'command' => $action->commands(),
                'authorize' => $action->authorize(),
            ],
            'success' => true,
        ]);
    }

    public function executeTask($task_name)
    {
        $action = CDP::action($task_name);

        if(CDP::shouldQueue($task_name)){
            dispatch(CDP::queueClass($action));
        } else{
            $action->execute();
        }

        return response('', 201);
    }

}
