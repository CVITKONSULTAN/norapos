<?php

namespace App\Helpers;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

use DB;


class Helper {

    public static function DataReturn($status = false ,$msg = "",$data = [] ) {
        return ['status'=>$status,"message"=>$msg,"data"=>$data];
    }

    public static function sendPush(Array $data){
        try {
            $file = config('firebase.credentials')['file'];
            $factory = (new Factory)
            ->withServiceAccount($file);
            $messaging = $factory->createMessaging();
    
            $message = CloudMessage::withTarget('token',$data['token'])
                // ->withNotification(Notification::create($data['title'], $data['body']))
                ->withHighestPossiblePriority()
                ->withData($data['payload'] ?? []);
    
            $messaging->send($message);
            return "OK";
        } catch (\Throwable $th) {
            //throw $th;
            info("notif itkonsultan error: " . $th->getMessage() ."line: " . $th->getLine());
            return false;
        }
    }

    public static function logSekolahActivity($user_id, $module, $action, $ref_id, $ref_type, $payload = [])
    {
        try {
            DB::table('sekolah_activities')->insert([
                'user_id'       => $user_id,
                'business_id'   => auth()->user()->business->id ?? null,
                'module'        => $module,
                'action'        => $action,
                'reference_id'  => $ref_id,
                'reference_type'=> $ref_type,
                'payload'       => json_encode($payload),
                'ip_address'    => request()->ip(),
                'user_agent'    => request()->header('User-Agent'),
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        } catch (\Throwable $e) {
            \Log::error("logSekolahActivity Error: " . $e->getMessage());
        }
    }


}
