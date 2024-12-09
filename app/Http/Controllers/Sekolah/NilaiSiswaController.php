<?php

namespace App\Http\Controllers\Sekolah;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use \App\Models\Sekolah\Kelas;
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

        $list_data = NilaiIntervalKeyword::query()
        ->whereRaw('CAST(nilai_minimum AS UNSIGNED) <= ? AND CAST(nilai_maksimum AS UNSIGNED) >= ?', [$nilai, $nilai])
        ->where('tipe',$params);

        // if($tipe == "min"){
        //     dd($nilai,$params,$list_data->first());
        // }

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

            if($update['nilai_max_tp'] <= $this->nilai_tengah_formatif){
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

            if($update['nilai_min_tp'] >= $this->nilai_tengah_formatif){
                $update['catatan_min_tp'] = "";
            } else {
                $catatan_min = $this->prosesPesan(
                    $update['nilai_min_tp'],
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

        if(!isset($input['tipe']))
        $update['catatan_max_tp'] = $input['catatan_max_tp'] ?? "";

        if(!isset($input['tipe']))
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

        $kelas = null;

        if($filter){
            if(
                isset($filter['tahun_ajaran']) &&
                isset($filter['semester']) &&
                isset($filter['nama_kelas'])
            ){
                $kelas = Kelas::where([
                    'tahun_ajaran' => $filter['tahun_ajaran'],
                    'semester' => $filter['semester'],
                    'nama_kelas' => $filter['nama_kelas'],
                ])->first();
            }
        }


        $mapel = null;
        if(isset($filter['mapel_id'])){
            $mapel_query = Mapel::where('nama','like',"%".$filter['mapel_id']."%");
            if(!empty($kelas)){
                $mapel_query = $mapel_query->where('kelas',$kelas->kelas);
            }
            $mapel = $mapel_query->first();
        }

        if(empty($mapel))
        $mapel = Mapel::first();

        // $data['list_data'] = NilaiSiswa::with([
        //     'siswa'=>function($q){
        //         return $q->select('id','nama');
        //     },
        // ])
        $data['list_data'] = NilaiSiswa::selectRaw(
            "nilai_siswas.*, siswas.nama, JSON_UNQUOTE(JSON_EXTRACT(siswas.detail, '$.nis')) AS nis"
        )
        ->join('siswas', 'nilai_siswas.siswa_id', '=', 'siswas.id')
        ->where([
            'mapel_id'=> $mapel->id
        ])
        ->with([ 'siswa'=>function($q){
                    return $q->select('id','nama');
                },
        ]);
            

        // order by nis
        // ->orderByRaw("CAST(JSON_UNQUOTE(JSON_EXTRACT(siswas.detail, '$.nis')) AS UNSIGNED)")

        if(!empty($kelas)){
            $data['list_data'] = $data['list_data']->where('kelas_id',$kelas->id);
        }

        return DataTables::of($data['list_data'])
        ->editColumn('nilai_tp',function($data){
            return json_decode($data->nilai_tp,true);
        })
        ->editColumn('nilai_sumatif',function($data){
            return json_decode($data->nilai_sumatif,true);
        })
        ->make(true);
    }

    function hitungNilaiRapor(Request $request){
        $kelas_id = $request->kelas_id ?? 0;
        $mapel_id = $request->mapel_id ?? 0;
        $ListNilai = NilaiSiswa::where([
            'kelas_id'=>$kelas_id,
            'mapel_id'=>$mapel_id,
        ])->get();
        foreach ($ListNilai as $key => $value) {
            
            $nilai_akhir_tp = $value->nilai_akhir_tp * 0.25;

            $nilai_sumatif = 0;
            $listSumatif = [];
            try {
                $listSumatif = json_decode($value->nilai_sumatif ?? "[]");
            } catch (\Throwable $th) {
                $listSumatif = [];
            }
            if(count($listSumatif) > 0){
                $collect = collect($listSumatif);
                $nilai_sumatif = $collect->sum() / $collect->count();
            }

            $nilai_SLA = 0;
            if($value->sumatif_tes > 0){
                $nilai_SLA = $value->sumatif_tes;
            }
            if($value->sumatif_non_tes > 0){
                $nilai_SLA = $value->sumatif_non_tes;
            }

            $nilai_akhir_sumatif = ($nilai_sumatif * 0.25) + ($nilai_SLA * 0.5);

            $value->nilai_akhir_sumatif = $nilai_akhir_sumatif;
            $value->nilai_rapor = $nilai_akhir_tp + $nilai_akhir_sumatif;
            // if($value->id === 3645){
            //     dd($value->nilai_rapor);
            // }
            $value->save();
        }
        return ['status'=>true,'msg'=>'Telah berhasil di hitung ulang...'];
    }


    function generateCatatanPenilaian(Request $request){
        $kelas_id = $request->kelas_id ?? 0;
        $mapel_id = $request->mapel_id ?? 0;
        $ListNilai = NilaiSiswa::where(['kelas_id'=>$kelas_id])->get();
        foreach ($ListNilai as $key => $data) {
            if($data->nilai_max_tp < $this->nilai_tengah_formatif){
                $data->catatan_max_tp = "";
            } else {
                $data->catatan_max_tp = $this->prosesPesan(
                    $data->nilai_max_tp,
                    'max',
                    $data
                );
            }
            if($data->nilai_min_tp >= $this->nilai_tengah_formatif){
                $data->catatan_min_tp = "";
            } else {
                $data->catatan_min_tp = $this->prosesPesan(
                    $data->nilai_min_tp,
                    'min',
                    $data
                );
            }
            $data->save();
        }
        // return ['status'=>true,'msg'=>'Catatan penilaian telah diperbaharui...'];
        return redirect()->back()
            ->with(['success'=>true,'message'=>"Catatan penilaian telah diperbaharui..."]);
    }
}
