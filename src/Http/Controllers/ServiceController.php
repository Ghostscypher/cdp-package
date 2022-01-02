<?php

namespace Ghostscypher\CDP\Http\Controllers;

use Ghostscypher\CDP\Facades\CDP;
use Ghostscypher\CDP\Http\Resources\ApiResource;
use Illuminate\Http\Request;

class ServiceController
{

   public function getCredentials($service_uuid)
   {
        $credential = CDP::serviceModel()
            ->where('service_uuid', $service_uuid)
            ->firstOrFail()
            ->credential()
            ->firstOrFail();

        return response()->json([
            'data' => [
                'key' => $credential->key,
                'secret' => $credential->secret,
            ],
            'success' => true,
        ]);
   }

   public function getLogs($service_uuid, $event_name = null, $type = null)
   {
        $logs = CDP::serviceModel()
            ->where('service_uuid', $service_uuid)
            ->firstOrFail()
            ->logs()
            ->when($event_name && $event_name !== '', function($query) use($event_name){
                return $query->where('event_name', $event_name);
            })->when($type && $type !== '', function($query) use($type){
                return $query->where('type', $type);
            })->get();

        return response()->json([
            'data' => $logs,
            'success' => true,
        ]);
   }

}
