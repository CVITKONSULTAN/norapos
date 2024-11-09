<?php

namespace App\Http\Controllers\Sekolah;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use \App\Models\Sekolah\Ekstrakurikuler;
use \App\Models\Sekolah\EkskulSiswa;
use DataTables;

class EkstrakurikulerController extends Controller
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
     * Display all data of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function data(Request $request)
    {
        $query = Ekstrakurikuler::orderBy('id','desc');

        return DataTables::of($query)
        ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $input = $request->all();
            if($request->insert == 1){
                Ekstrakurikuler::create($input);
                return [
                    'success'=>true,
                    'msg'=>'Data berhasil disimpan'
                ];
            }
            if($request->update == 1){
                $data = Ekstrakurikuler::find($request->id);
                if(empty($data))
                return [
                    'success'=>false,
                    'msg'=>'Data tidak ditemukan'
                ];

                $data->update($input);
                return [
                    'success'=>true,
                    'msg'=>'Data berhasil disimpan'
                ];
            }
        } catch (\Throwable $th) {
            $msg = $e->getMessage();
            return [
                'success'=>false,
                'msg'=>$msg
            ];
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
        try{
            $m = Ekstrakurikuler::findorfail($id);
            $m->delete();
            return ['success'=>true,'msg'=>'Data berhasil dihapus'];
        } catch(Exception $e){
            $msg = $e->getMessage();
            return ['success'=>false,'msg'=>$msg];
        }
    }

    function ekskul_siswa(Request $request){
        try {

            $ekskul = EkskulSiswa::where([
                'kelas_id' => $request->kelas_id,
                'siswa_id' => $request->siswa_id
            ])
            ->with('siswa','ekskul')
            ->get();

            return [
                'success'=>true,
                'msg'=>'OK',
                'data' => $ekskul
            ];

        } catch(Exception $e){
            $msg = $e->getMessage();
            return ['success'=>false,'msg'=>$msg];
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeEkskulSiswa(Request $request)
    {
        try {
            $input = $request->all();
            if($request->show == 1){

                $data = EkskulSiswa::where('id',$request->id)
                ->with('ekskul')
                ->first();

                if(empty($data))
                return [
                    'success'=>false,
                    'msg'=>'Data tidak ditemukan'
                ];

                return [
                    'success'=>true,
                    'msg'=>'OK',
                    'data'=>$data
                ];
            }
            if($request->insert == 1){
                EkskulSiswa::create($input);
                return [
                    'success'=>true,
                    'msg'=>'Data berhasil disimpan'
                ];
            }
            if($request->update == 1){
                $data = EkskulSiswa::find($request->id);
                if(empty($data))
                return [
                    'success'=>false,
                    'msg'=>'Data tidak ditemukan'
                ];

                $data->update($input);
                return [
                    'success'=>true,
                    'msg'=>'Data berhasil disimpan'
                ];
            }
            if($request->delete == 1){
                $data = EkskulSiswa::find($request->id);
                if(empty($data))
                return [
                    'success'=>false,
                    'msg'=>'Data tidak ditemukan'
                ];

                $data->delete();
                return [
                    'success'=>true,
                    'msg'=>'Data berhasil dihapus'
                ];
            }
        } catch(Exception $e){
            $msg = $e->getMessage();
            return [
                'success'=>false,
                'msg'=>$msg
            ];
        }
    }
}
