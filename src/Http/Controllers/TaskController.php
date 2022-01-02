<?php

namespace Ghostscypher\CDP\Http\Controllers;

use Ghostscypher\CDP\Http\Resources\ApiResource;
use Ghostscypher\CDP\Facades\CDP;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

        $validator = Validator::make(array_merge(['task_name' => $task_name], $request->all()), $action->rules());

        if($validator->fails()){
            return response()
                ->json([
                    'data' => $validator->errors(),
                    'success' => false,
                ])
                ->setStatusCode(422);
        }

        if(CDP::shouldQueue($task_name)){
            dispatch(CDP::queueClass($action, $validator->validated()));
        } else{
            $action->execute($validator->validated());
        }

        return response('', 201);
    }

}
