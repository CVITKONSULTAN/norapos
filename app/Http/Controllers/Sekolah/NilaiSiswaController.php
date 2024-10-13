<?php

namespace App\Http\Controllers\Sekolah;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use \App\Models\Sekolah\NilaiSiswa;

class NilaiSiswaController extends Controller
{
    function showNilaiFormatif($id){
        $data = NilaiSiswa::find($id);
        if(empty($data))
        return ['success'=>false,'mesage'=>"Data not found"];

        $data = $data->with([
            'siswa'=>function($q){
                return $q->select('id','nama','nisn');
            }
        ])->first();
        return ['success'=>true,'mesage'=>"OK","data"=>$data];

    }
    function storeNilaiFormatif(Request $request){
        $input = $request->all();
        $data = NilaiSiswa::find($input['id'] ?? 0);

        $update = [];

        if(empty($data))
        return ['success'=>false,'mesage'=>"Data not found"];

        if(isset($input['nilai_tp'])){
            $nilai_tp = $input['nilai_tp'] ?? [];
            $update['nilai_max_tp'] = max($nilai_tp);
            $update['kolom_max_tp'] = array_search($update['nilai_max_tp'], $nilai_tp);
    
            $update['nilai_min_tp'] = min($nilai_tp);
            $update['kolom_min_tp'] = array_search($update['nilai_min_tp'], $nilai_tp);
    
            if(count($nilai_tp) > 0){
                $update['nilai_akhir_tp'] = array_sum($nilai_tp)/count($nilai_tp);
            }
    
            $update['nilai_tp'] = json_encode($nilai_tp);
        }

        $update['catatan_max_tp'] = $input['catatan_max_tp'] ?? "";
        $update['catatan_min_tp'] = $input['catatan_min_tp'] ?? "";

        $data->update($update);

        return ['success'=>true,'mesage'=>"Data berhasil di simpan"];
    }
}
