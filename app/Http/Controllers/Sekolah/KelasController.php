<?php

namespace App\Http\Controllers\Sekolah;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use \App\Models\Sekolah\Kelas;
use \App\Models\Sekolah\NilaiSiswa;
use \App\Models\Sekolah\Mapel;
use \App\Models\Sekolah\KelasSiswa;
use \App\Models\Sekolah\JurnalKelas;
use \App\Models\Sekolah\TenagaPendidik;

use \App\Imports\KelasSiswaImport;

use Illuminate\Support\Facades\DB;

use DataTables;
use Excel;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function data(Request $request)
    {
        $user = $request->user();
        
        // $query = KelasSiswa::select(
        //     'id',
        //     'siswa_id',
        //     'kelas_id',
        //     'hadir',
        //     'izin',
        //     'sakit',
        //     'tanpa_keterangan',
        // )
        $query = KelasSiswa::select(
            'kelas_siswas.*', 
            // 'siswas.nama',
            // 'siswas.nis'
        )
        // ->join('siswas', 'kelas_siswas.siswa_id', '=', 'siswas.id') // Join ke tabel siswas
        // ->orderBy('siswas.nama', 'asc')
        ->with([
            'siswa' => function($q){
                $q->select('id','nama','nisn');
            },
            'kelas' => function($q){
                $q->select(
                    'id',
                    'tahun_ajaran',
                    'semester',
                    'nama_kelas',
                );
            },
        ]);

        if(
            $request->has('filter_tahun_ajaran')&&
            $request->has('filter_semester') &&
            $request->has('filter_kelas')
        ){  
            $kelas = Kelas::where([
                'tahun_ajaran'=>$request->filter_tahun_ajaran,
                'semester'=>$request->filter_semester,
                'nama_kelas'=>$request->filter_kelas,
            ])->first();
            if(!empty($kelas)){
                $request->kelas_id = $kelas->id;
            }
        }

        if($request->kelas_id){
            $query = $query->where('kelas_id',$request->kelas_id);
        }

        if(!$user->checkAdmin() && empty($request->kelas_id)){
            return DataTables::of([])->make(true);
        }

        return DataTables::of($query)
        ->addColumn('nama_siswa',function($q){
            return $q->siswa->nama;
        })
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $input = $request->all();
            if(
                isset($input['show']) &&
                $input['show'] == 1
            ){
                $m = KelasSiswa::where('id',$input['id'])
                ->with([
                    'siswa' => function($q){
                        $q->select('id','nama','nisn');
                    },
                    'kelas' => function($q){
                        $q->select(
                            'id',
                            'tahun_ajaran',
                            'semester',
                            'nama_kelas',
                        );
                    },
                ])
                ->first();
                if(empty($m))
                    return ['success'=>false,'msg'=>'not found','data'=>$m];

                return ['success'=>true,'msg'=>'OK','data'=>$m];
            }
            if(
                isset($input['insert']) &&
                $input['insert'] == 1
            ){
                $k = KelasSiswa::create($input);
                $kelas_data = Kelas::find($input['kelas_id']);
                $this->storeKelasMapel($k,$kelas_data->kelas);
                return ['success'=>true,'msg'=>'Data berhasil disimpan'];
            }
            if(isset($input['update']) && $input['update'] == 1){
                $m = KelasSiswa::findorfail($input['id']);
                $m->update($input);
                return ['success'=>true,'msg'=>'Data berhasil disimpan'];
            }
            if(isset($input['delete']) && $input['delete'] == 1){
                $m = KelasSiswa::findorfail($input['id']);
                $m->delete();
                return ['success'=>true,'msg'=>'Data berhasil dihapus'];
            }
        } catch(Exception $e){
            $msg = $e->getMessage();
            return ['success'=>false,'msg'=>$msg];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    function KelasRepo(Request $request){
        try{
            $input = $request->all();
            if(
                isset($input['show']) &&
                $input['show'] == 1
            ){
                $m = Kelas::findorfail($input['id']);
                return ['success'=>true,'msg'=>'OK','data'=>$m];
            }
            if(isset($input['delete']) && $input['delete'] == 1){
                $m = Kelas::findorfail($input['id']);
                $m->delete();
                return ['success'=>true,'msg'=>'Data berhasil dihapus'];
            }
            if($request->has('wali_kelas_id')){
                $tendik = TenagaPendidik::find($request->wali_kelas_id);
                if(!empty($tendik)){
                    $input['nama_wali_kelas'] = $tendik->nama;
                    $input['nbm_wali_kelas'] = $tendik->nbm;
                    $user_id = $tendik->user->id;
                    $input['wali_kelas_id'] = $user_id;
                }
            }

            if(
                isset($input['insert']) &&
                $input['insert'] == 1
            ){
                Kelas::create($input);
                return ['success'=>true,'msg'=>'Data berhasil disimpan'];
            }
            if(isset($input['update']) && $input['update'] == 1){
                $m = Kelas::findorfail($input['id']);
                
                $m->update($input);
                return ['success'=>true,'msg'=>'Data berhasil disimpan'];
            }
        } catch(Exception $e){
            $msg = $e->getMessage();
            return ['success'=>false,'msg'=>$msg];
        }
    }

    function KelasData(Request $request){
        $query = Kelas::query();
        if($request->filter_list_id){
            try{
                $filter_list_id = json_decode($request->filter_list_id,true);
            } catch(Exception $e){
                $filter_list_id = [];
            }
            $query = $query->whereIn('id',$filter_list_id);
        }
        if($request->kelas){
            $query = $query->where('kelas',$request->kelas);
        }
        if($request->kelas_list){
            $query = $query->whereIn('kelas',$request->kelas_list);
        }
        return DataTables::of($query)
        ->make(true);
    }

    function storeKelasMapel($k,$kelas){
        // try{
            $mapel = Mapel::where('kelas',$kelas)->get();
            // dd($mapel->count());
            foreach($mapel as $item){
                $n = NilaiSiswa::where([
                    'siswa_id'=> $k->siswa_id,
                    'kelas_id'=> $k->kelas_id,
                    'mapel_id'=> $item->id,
                ])->first();
                // dd($n,$kelas);
                if(empty($n)){
                    $n = NilaiSiswa::create([
                        'siswa_id'=> $k->siswa_id,
                        'kelas_id'=> $k->kelas_id,
                        'mapel_id'=> $item->id,
                        'tp_mapel' => json_encode($item->tujuan_pembelajaran),
                        'lm_mapel' => json_encode($item->lingkup_materi),
                    ]);
                } else {
                    $n->update([
                        'tp_mapel' => json_encode($item->tujuan_pembelajaran),
                        'lm_mapel' => json_encode($item->lingkup_materi),
                        'nilai_tp' => null,
                        'nilai_akhir_tp' => null,
                        'nilai_sumatif' => null,
                        'nilai_akhir_sumatif' => null,
                        'nilai_rapor' => null,

                        'kolom_max_tp' => null,
                        'nilai_max_tp' => null,
                        'catatan_max_tp' => null,
                        'kolom_min_tp' => null,
                        'nilai_min_tp' => null,
                        'catatan_min_tp' => null,

                        'sumatif_tes' => null,
                        'sumatif_non_tes' => null,

                    ]);
                }
            }
            return ['success'=>true,'msg'=>'Data berhasil dihapus'];
        // } catch(Exception $e){
        //     $msg = $e->getMessage();
        //     return ['success'=>false,'msg'=>$msg];
        // }
    }

    function storeJurnalKelas(Request $request){
        $user_id = $request->user()->id;
        $check = JurnalKelas::where([
            "kelas_id" => $request->kelas_id,
            "nama_mapel" => $request->nama_mapel,
            "tanggal" => $request->tanggal
        ])->first();
        if(!empty($check)){
            return ['success'=>false,'msg'=>'Data sudah pernah di simpan sebelumnya'];
        }
        $input = [
            'user_id'=>$user_id,
            "kelas_id" => $request->kelas_id,
            "mapel_id" => $request->mapel_id,
            "tanggal" => $request->tanggal,
            "nama_mapel" => $request->nama_mapel,
            "jurnal" => json_encode($request->jurnal ?? [])
        ];
        JurnalKelas::create($input);
        return [
            'success'=>true,
            'msg'=>'Data berhasil disimpan'
        ];
    }

    function kelasSiswaImport(Request $request){

        $kelas_id = $request->kelas_id;

        Excel::import(
            new KelasSiswaImport([
                'kelas_id'=>$kelas_id
            ]), 
            request()->file('import_file')
        );
        return redirect()
        ->back()
        ->with('success', 'All good!');
    }

    function detail(Request $request,$id){
        $kelas = KelasSiswa::find($id);
        return ['status'=>true,'data'=>$kelas];
    }

    function hitungJurnalAbsen(Request $request){
        $kelas_id = $request->kelas_id;
        $kelasList = KelasSiswa::where('kelas_id',$kelas_id)->get();
        foreach($kelasList as $i => $item){
            $result = DB::select("
                SELECT
                COUNT(CASE WHEN JSON_UNQUOTE(JSON_EXTRACT(jurnal, '$.".$item->siswa_id."')) = 'hadir' THEN 1 END) AS jumlah_hadir,
                COUNT(CASE WHEN JSON_UNQUOTE(JSON_EXTRACT(jurnal, '$.".$item->siswa_id."')) = 'izin' THEN 1 END) AS jumlah_izin,
                COUNT(CASE WHEN JSON_UNQUOTE(JSON_EXTRACT(jurnal, '$.".$item->siswa_id."')) = 'sakit' THEN 1 END) AS jumlah_sakit,
                COUNT(CASE WHEN JSON_UNQUOTE(JSON_EXTRACT(jurnal, '$.".$item->siswa_id."')) = 'tanpa keterangan' THEN 1 END) AS jumlah_absen
                FROM jurnal_kelas where mapel_id is null
            ");
            $result = $result[0];
            $item->hadir = $result->jumlah_hadir;
            $item->izin = $result->jumlah_izin;
            $item->sakit = $result->jumlah_sakit;
            $item->tanpa_keterangan = $result->jumlah_absen;
            $item->hitungan_sistem = $result;
            $item->save();
        }
        return ['status'=>true,'message'=>"Data berhasil dikalkulasi"];
    }

}
