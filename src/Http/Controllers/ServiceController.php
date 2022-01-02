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

}
