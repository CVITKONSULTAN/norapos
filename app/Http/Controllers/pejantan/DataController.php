<?php

namespace App\Http\Controllers\pejantan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;

class DataController extends Controller
{
    function sk_jalan(Request $request){
        try {
            $data = DB::table('sk_jalan')->get();
            return Helper::DataReturn(true,"OK",$data);
        } catch (\Throwable $th) {
            return Helper::DataReturn(false,$th->getMessage());
        }
    }
}