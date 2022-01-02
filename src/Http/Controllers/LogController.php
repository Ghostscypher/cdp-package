<?php

namespace Ghostscypher\CDP\Http\Controllers;

use Ghostscypher\CDP\Facades\CDP;
use Ghostscypher\CDP\Http\Resources\ApiResource;
use Illuminate\Http\Request;

class LogController
{
   public function getLogs(Request $request, $type = null)
   {
        return new ApiResource(
            app('cdp_credentials')
            ->service->logs()
            ->when($type !== '', function($query) use ($type) {
                return $query->where('type', $type);
            })
            ->paginate());
   }

   public function getServiceLogs($service_uuid, $type)
   {
        return new ApiResource(
                CDP::serviceModel()
                ->where('service_uuid', $service_uuid)
                ->service->logs()
                ->when($type !== '', function($query) use ($type) {
                    return $query->where('type', $type);
                })
                ->paginate());
   }

}
