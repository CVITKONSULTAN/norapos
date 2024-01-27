<?php

namespace App\Helpers;

class Helper {

    public static function DataReturn($status = false ,$msg = "",$data = [] ) {
        return ['status'=>$status,"message"=>$msg,"data"=>$data];
    }

}
