<?php

namespace Ghostscypher\CDP\Http\Controllers;

use Ghostscypher\CDP\Http\Resources\ApiResource;
use Ghostscypher\CDP\Facades\CDP;

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

    }
}
