<?php

namespace App\Http\Controllers\Sekolah;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use \App\Models\Sekolah\Kelas;
use \App\Models\Sekolah\NilaiSiswa;
use \App\Models\Sekolah\KelasSiswa;
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

    public function data()
    {
        $query = KelasSiswa::select(
            'id',
            'siswa_id',
            'kelas_id',    
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
                $m = KelasSiswa::findorfail($input['id']);
                return ['success'=>true,'msg'=>'OK','data'=>$m];
            }
            if(
                isset($input['insert']) &&
                $input['insert'] == 1
            ){
                KelasSiswa::create($input);
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

}
