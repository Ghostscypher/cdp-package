<?php

namespace Ghostscypher\CDP\Http\Controllers;

use Ghostscypher\CDP\Facades\CDP;
use Ghostscypher\CDP\Http\Resources\ApiResource;
use Illuminate\Http\Request;

class LogController
{
   public function getLogs($type = null)
   {
        return new ApiResource(
            CDP::logModel()
            ->when($type && $type !== '', function($query) use ($type) {
                return $query->where('type', $type);
            })
            ->paginate());
   }

   public function getLogsByName($name, $type = null)
   {
        return new ApiResource(
            CDP::logModel()
                ->where('event_name', $name)
                ->when($type && $type !== '', function($query) use ($type) {
                    return $query->where('type', $type);
                })
                ->paginate());
   }

}
