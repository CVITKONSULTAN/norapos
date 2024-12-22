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

    function chart(Request $request){
        $tipe = $request->tipe ?? "";
        switch ($tipe) {
            case 'panjang_jalan_kecamatan':
                $result = [];
                $Kecamatan = DB::table('sk_jalan')->groupBy('KECAMATAN');
                foreach ($Kecamatan as $key => $value) {
                    $result[$value] = DB::table('sk_jalan')->where('KECAMATAN',$value)
                    ->sum('PANJANG');
                }
                return Helper::DataReturn(true,"OK",$result);
                break;
            case 'tipe_jembatan':
                $result = [];
                $tipe = DB::table('sk_jembatan')->groupBy('Tipe');
                foreach ($tipe as $key => $value) {
                    $result[] = DB::table('sk_jembatan')->where('Tipe',$value)
                    ->sum('Tipe');
                }
                return Helper::DataReturn(true,"OK",$result);
                break;
            case 'jembatan_perkecamatan':
                $result = [];
                $Kecamatan = DB::table('sk_jembatan')->groupBy('KECAMATAN');
                foreach ($Kecamatan as $key => $value) {
                    $result[$value] = DB::table('sk_jembatan')->where('KECAMATAN',$value)
                    ->count();
                }
                return Helper::DataReturn(true,"OK",$result);
                break;
            
            default:
                return Helper::DataReturn(false,"Tipe tidak ditemukan");
                break;
        }
    }
}