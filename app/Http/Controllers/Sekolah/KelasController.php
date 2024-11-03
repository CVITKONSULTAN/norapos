<?php

namespace App\Http\Controllers\Sekolah;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use \App\Models\Sekolah\Kelas;
use \App\Models\Sekolah\NilaiSiswa;
use \App\Models\Sekolah\Mapel;
use \App\Models\Sekolah\KelasSiswa;
use \App\Models\Sekolah\JurnalKelas;
use DataTables;

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
        $query = KelasSiswa::select(
            'id',
            'siswa_id',
            'kelas_id',
            'hadir',
            'izin',
            'sakit',
            'tanpa_keterangan',
        )
        // ->with('siswa','kelas');
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

        if($request->has('kelas_id')){
            $query = $query->where('kelas_id',$request->kelas_id);
        }

        return DataTables::of($query)->make(true);
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
                $this->storeKelasMapel($k);
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
            if(isset($input['delete']) && $input['delete'] == 1){
                $m = Kelas::findorfail($input['id']);
                $m->delete();
                return ['success'=>true,'msg'=>'Data berhasil dihapus'];
            }
        } catch(Exception $e){
            $msg = $e->getMessage();
            return ['success'=>false,'msg'=>$msg];
        }
    }

    function KelasData(Request $request){
        $query = Kelas::query();
        return DataTables::of($query)
        ->make(true);
    }

    function storeKelasMapel($k){
        try{
            $mapel = Mapel::all();
            foreach($mapel as $item){
                NilaiSiswa::create([
                    'siswa_id'=> $k->siswa_id,
                    'kelas_id'=> $k->kelas_id,
                    'mapel_id'=> $item->id
                ]);
            }
            return ['success'=>true,'msg'=>'Data berhasil dihapus'];
        } catch(Exception $e){
            $msg = $e->getMessage();
            return ['success'=>false,'msg'=>$msg];
        }
    }

    function storeJurnalKelas(Request $request){
        $user_id = $request->user()->id;
        $check = JurnalKelas::where([
            "kelas_id" => $request->kelas_id,
            "mapel_id" => $request->mapel_id,
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
            "jurnal" => json_encode($request->jurnal ?? [])
        ];
        JurnalKelas::create($input);
        return [
            'success'=>true,
            'msg'=>'Data berhasil disimpan'
        ];
    }

}
