<?php

namespace App\Http\Controllers\pejantan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
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

    function sk_jembatan(Request $request){
        try {
            $data = DB::table('sk_jembatan')->get();
            return Helper::DataReturn(true,"OK",$data);
        } catch (\Throwable $th) {
            return Helper::DataReturn(false,$th->getMessage());
        }
    }

    function config(Request $request){
        try {
            $tipe = $request->tipe ?? "";
            $data = DB::table('sk_config')->where('tipe',$tipe)->first();
            return Helper::DataReturn(true,"OK",$data);
        } catch (\Throwable $th) {
            return Helper::DataReturn(false,$th->getMessage());
        }
    }
}