<?php

namespace App\Helpers;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;


class Helper {

    public static function DataReturn($status = false ,$msg = "",$data = [] ) {
        return ['status'=>$status,"message"=>$msg,"data"=>$data];
    }

    public static function sendPush(Array $data){

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
    }



}
