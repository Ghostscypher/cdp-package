<?php

namespace Ghostscypher\CDP\Http\Controllers;

use Ghostscypher\CDP\Http\Resources\ApiResource;
use Ghostscypher\CDP\Facades\CDP;
use Illuminate\Http\Request;

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

    public function executeTask(Request $request, $task_name)
    {
        $action = CDP::action($task_name);

        if(!$action){
            abort(404);
        }

        $request->validate($action->rules());

        if(CDP::shouldQueue($task_name)){
            dispatch(CDP::queueClass($action, $request->all()));
        } else{
            $action->execute($request->all());
        }

        return response('', 201);
    }

}
