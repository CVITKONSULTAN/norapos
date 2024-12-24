<?php

namespace App\Http\Controllers\pejantan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use DB;
use DataTables;

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
            case 'kerusakan_jalan':
                $result = [];
                $jenis = [
                    "BAIK_KM",
                    "SEDANG_KM",
                    "RUSAK_RINGAN_KM",
                    "RUSAK_BERAT_KM"
                ];
                foreach ($jenis as $key => $value) {
                    // dd($value);
                    $result[$value] = DB::table('sk_jalan')
                    ->sum($value);
                }
                return Helper::DataReturn(true,"OK",$result);
                break;
            case 'panjang_jalan_kecamatan':
                $result = [];
                $Kecamatan = DB::table('sk_jalan')->groupBy('KECAMATAN')->get();
                foreach ($Kecamatan as $key => $value) {
                    $result[$value->KECAMATAN] = DB::table('sk_jalan')->where('KECAMATAN',$value->KECAMATAN)
                    ->sum('PANJANG');
                }
                return Helper::DataReturn(true,"OK",$result);
                break;
            case 'tipe_jembatan':
                $result = [];
                $tipe = DB::table('sk_jembatan')->groupBy('Tipe')->get();
                foreach ($tipe as $key => $value) {
                    $result[$value->Tipe] = DB::table('sk_jembatan')->where('Tipe',$value->Tipe)
                    ->count();
                }
                return Helper::DataReturn(true,"OK",$result);
                break;
            case 'jembatan_perkecamatan':
                $result = [];
                $Kecamatan = DB::table('sk_jembatan')->groupBy('Kecamatan')->get();
                foreach ($Kecamatan as $key => $value) {
                    // dd($value);
                    $result[$value->Kecamatan] = DB::table('sk_jembatan')->where('Kecamatan',$value->Kecamatan)
                    ->count();
                }
                return Helper::DataReturn(true,"OK",$result);
                break;
            
            default:
                return Helper::DataReturn(false,"Tipe tidak ditemukan");
                break;
        }
    }

    function jalan(Request $request){
        $query = DB::table('sk_jalan');
        return DataTables::of($query)
        ->make(true);
    }

    function jembatan(Request $request){
        $query = DB::table('sk_jembatan');
        return DataTables::of($query)
        ->make(true);
    }

    function home(Request $request){
        $data['jembatan'] = DB::table('sk_jembatan')->count();
        $data['jalan'] = DB::table('sk_jalan')->count();
        return Helper::DataReturn(true,"OK",$data);
    }
}