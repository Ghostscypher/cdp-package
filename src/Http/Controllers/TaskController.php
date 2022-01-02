<?php

namespace Ghostscypher\CDP\Http\Controllers;

use Ghostscypher\CDP\Http\Resources\ApiResource;
use Ghostscypher\CDP\Facades\CDP;

class TaskController
{
    /**
     * @return ApiResource list of API tasks
     */
    public function getTasks(): ApiResource
    {
        
        $service = CDP::service();

        dd($service);

        if($service['type'] === 'main'){
            return new ApiResource([]);
        }

        return new ApiResource(array_keys($service['tasks']));
    }   
}
