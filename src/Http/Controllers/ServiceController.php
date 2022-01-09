<?php

namespace Ghostscypher\CDP\Http\Controllers;

use Ghostscypher\CDP\Facades\CDP;
use Ghostscypher\CDP\Http\Resources\ApiResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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

   public function getStatus($service_uuid)
   {
        $service = CDP::serviceModel()
            ->where('service_uuid', $service_uuid)
            ->firstOrFail();

        return response()->json([
            'data' => [
                'status' => $service->status,
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

   public function createService(Request $request){
        $validator = Validator::make($request->all(), [
            'product_name' => ['bail', 'required', 'string'],
            'deployment_url' => ['bail', 'required', 'url'],    
        ]);

        if($validator->fails()){
            return response()
                ->json([
                    'data' => $validator->errors(),
                    'success' => false,
                ])
                ->setStatusCode(422);
        }

        $url = parse_url($request->deployment_url);
        $url = sprintf("%s://%s", $url['scheme'], $url['host']);
        
        $service = CDP::serviceModel()
            ->with(['credential'])
            ->where([
                'product_name' => $request->product_name,
                'deployment_url' => $url,
            ])->first();

        if($service){
            return response()->json([
                'data' => [
                    'service' => $service,
                    'credentials' => [
                        'key' => $service->credential->key,
                        'secret' => $service->credential->secret,
                    ],
                ],
                'success' => true,
            ]);
        }

        DB::beginTransaction();

        try{
            $service = CDP::serviceModel()->create([
                'service_uuid' => Str::uuid(),
                'product_name' => $request->product_name,
                'deployment_url' => $url,
                'type' => 'client',
                'status' => 'active',
            ]);

            $service->credential()->create([
                'key' => Str::random(32), 
                'secret' => Str::random(16),
            ]);

            DB::commit();
            
        } catch(\Throwable $th){
            DB::rollBack();
            Log::error($th);

            return response()->json([
                'data' => null,
                'success' => false,
            ], 500);
        }

        return response()->json([
            'data' => [
                'service' => $service,
                'credentials' => [
                    'key' => $service->credential->key,
                    'secret' => $service->credential->secret,
                ],
            ],
            'success' => true,
        ]);
   }

   public function deleteService($service_uuid){
        if(CDP::serviceModel()->where('type', 'client')->count() === 1){
            return response()->json([
                'data' => [
                    'message' => 'At least one service must be remain, you can delete this manually using cdp-client:delete',
                ],
                'success' => false,
            ], 400);
        }

        $service = CDP::serviceModel()->where([
                    'type' => 'client',
                    'service_uuid' => $service_uuid,
                ])->firstOrFail();

        $service->delete();

        return response()->json([
            'data' => null,
            'success' => true,
        ]);
   }

   public function activateService($service_uuid){
        $service = CDP::serviceModel()->where([
                    'type' => 'client',
                    'service_uuid' => $service_uuid,
                ])->firstOrFail();

        $service->update([
            'status' => 'active',
        ]);

        return response()->json([
            'data' => null,
            'success' => true,
        ]);
    }

    public function deActivateService($service_uuid){
        $service = CDP::serviceModel()->where([
                    'type' => 'client',
                    'service_uuid' => $service_uuid,
                ])->firstOrFail();

        $service->update([
            'status' => 'inactive',
        ]);

        return response()->json([
            'data' => null,
            'success' => true,
        ]);
    }

}
