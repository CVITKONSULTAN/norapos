<?php

namespace App\Http\Controllers\itkonsultan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Helpers\Helper;

use DB;

class WilayahController extends Controller
{
    function getData(Request $request){
        try {
            $wil = [
                2 => [
                    5,
                    'Kota/Kabupaten',
                    'kab'
                ],
                5 => [
                    8,
                    'Kecamatan',
                    'kec'
                ],
                8 => [
                    13,
                    'Kelurahan',
                    'kel'
                ]
            ];
            $db_query = DB::connection('wilayah_db');
            if ( $request->has('id') && !empty($request->id)){
                $n = strlen($request->id);
                $id = $request->id;
                $m = $wil[$n][0];
                $data = $db_query->select(DB::raw("SELECT* FROM wilayah WHERE LEFT(kode,$n)='$id' AND CHAR_LENGTH(kode)=$m ORDER BY nama"));
                return Helper::DataReturn(true,"OK",$data);
            }
            $data = $db_query->select(DB::raw("SELECT kode,nama FROM wilayah WHERE CHAR_LENGTH(kode)=2 ORDER BY nama"));
            return Helper::DataReturn(true,"OK",$data);
        } catch (\Throwable $th) {
            return Helper::DataReturn(
                false,
                "SERVER ERROR (501)",
                ['message' => $th->getMessage()]
            );
        }

    }
}
