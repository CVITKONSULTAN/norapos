<?php

namespace App\Http\Controllers\Sekolah;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use \App\Models\Sekolah\NilaiSiswa;
use \App\Models\Sekolah\Mapel;
use \App\Models\Sekolah\NilaiIntervalKeyword;
use DataTables;
class NilaiSiswaController extends Controller
{

    private $nilai_tengah_formatif = 68;

    private function prosesPesan($nilai,$tipe,$data){
        $params = 'terendah';
        if($tipe == "max")
        $params = 'tertinggi';

        $list_data = NilaiIntervalKeyword::query();
        $list_data->whereRaw('CAST(nilai_minimum AS UNSIGNED) <= ? AND CAST(nilai_maksimum AS UNSIGNED) >= ?', [$nilai, $nilai]);
        $check = $list_data->first();
        if(empty($check))
        return "";

        $format = $check->formatter_string ?? "";
        if (strpos($format, "@nama@") !== false) {
            $format = str_replace("@nama@",$data->siswa->nama,$format);
        }
        if (strpos($format, "@tp_nama@") !== false) {
            $format = str_replace("@tp_nama@",$data->tp_keterangan,$format);
        }

        return $format;
        
    }

    function showNilaiFormatif($id){

        $data = NilaiSiswa::with([
            'siswa'=>function($q){
                return $q->select('id','nama','nisn');
            }
        ])->find($id);

        if(empty($data))
        return ['success'=>false,'mesage'=>"Data not found"];

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
            $data->tp_keterangan = $data->mapel->tujuan_pembelajaran[$update['kolom_max_tp']] ?? "";

            if($update['nilai_max_tp'] < $this->nilai_tengah_formatif){
                $update['catatan_max_tp'] = "";
            } else {
                $catatan_max = $this->prosesPesan(
                    $update['nilai_max_tp'],
                    'max',
                    $data
                );
                $update['catatan_max_tp'] = $catatan_max;
            }

    
            $update['nilai_min_tp'] = min($nilai_tp);
            $update['kolom_min_tp'] = array_search($update['nilai_min_tp'], $nilai_tp);
            $data->tp_keterangan = $data->mapel->tujuan_pembelajaran[$update['kolom_min_tp']] ?? "";

            if($update['nilai_min_tp'] > $this->nilai_tengah_formatif){
                $update['catatan_min_tp'] = "";
            } else {
                $catatan_min = $this->prosesPesan(
                    $update['nilai_max_tp'],
                    'min',
                    $data
                );
                $update['catatan_min_tp'] = $catatan_min;
            }
    
            if(count($nilai_tp) > 0){
                $update['nilai_akhir_tp'] = array_sum($nilai_tp)/count($nilai_tp);
            }
    
            $update['nilai_tp'] = json_encode($nilai_tp);

            if(isset($data->tp_keterangan))
            unset($data->tp_keterangan);

        }

        // if(isset($input['catatan_max_tp']))
        $update['catatan_max_tp'] = $input['catatan_max_tp'] ?? "";

        // dd(isset($input['catatan_min_tp']) , $input['catatan_min_tp'] );
        // if(isset($input['catatan_min_tp']))
        $update['catatan_min_tp'] = $input['catatan_min_tp'] ?? "";

        if(isset($input['nilai_sumatif'])){
            $nilai_sumatif = $input['nilai_sumatif'] ?? [];
            $update['nilai_sumatif'] = json_encode($nilai_sumatif);

            $update['sumatif_tes'] = $input['sumatif_tes'] ?? 0;
            $update['sumatif_non_tes'] = $input['sumatif_non_tes'] ?? 0;
            
            $update['nilai_akhir_sumatif'] = $input['nilai_akhir_sumatif'] ?? 0;
            $update['nilai_rapor'] = $input['nilai_rapor'] ?? 0;
        }

        $data->update($update);

        return ['success'=>true,'mesage'=>"Data berhasil di simpan"];
    }

    function data(Request $request){

        $filter = $request->all();

        $mapel = null;
        if(isset($filter['mapel_id'])){
            $mapel = Mapel::find($filter['mapel_id']);
        }

        if(empty($mapel))
        $mapel = Mapel::first();

        $data['list_data'] = NilaiSiswa::with([
            'siswa'=>function($q){
                return $q->select('id','nama');
            },
        ])
        ->where([
            'mapel_id'=> $mapel->id
        ]);

        $data['list_data'] = $data['list_data']->whereHas('kelas',function($q) use ($filter){
            if(isset($filter['tahun_ajaran'])){
                $q->where('tahun_ajaran',$filter['tahun_ajaran']);
            }
            if(isset($filter['semester'])){
                $q->where('semester',$filter['semester']);
            }
            if(isset($filter['nama_kelas'])){
                $q->where('nama_kelas',$filter['nama_kelas']);
            }
            return $q;
        });

        return DataTables::of($data['list_data'])
        ->editColumn('nilai_tp',function($data){
            return json_decode($data->nilai_tp,true);
        })
        ->make(true);
    }
}
