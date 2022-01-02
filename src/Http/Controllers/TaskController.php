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
        
        $service = CDP::service();

        return response()->json([
            'data' => array_keys($service['tasks']),
            'success' => true,
        ]);
    }   
}
