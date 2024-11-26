<?php

namespace App\Http\Controllers\Sekolah;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

use Excel;

use \App\Imports\MapelImport;
use \App\Models\Sekolah\Mapel;
use \App\Models\Sekolah\Kelas;
use \App\Models\Sekolah\KelasSiswa;
use \App\Models\Sekolah\NilaiSiswa;
use \App\Http\Controllers\Sekolah\KelasController;
use \App\Http\Controllers\SekolahSDController;

class MapelController extends Controller
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
     * Display all data of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function data(Request $request)
    {
        $user = $request->user();
        if(
            $user->checkGuruMapel() ||
            $user->checkGuruWalikelas()
        ){
            $request->mapel_list = json_decode($user->tendik->mapel_id_list ?? "[]",true);
            if(empty($request->mapel_list)) $request->mapel_list = [];
        }

        $business_id = $user->business->id;
        $query = Mapel::select('id','nama','kategori','kelas')
        ->where('business_id',$business_id);

        
        if($request->mapel_list)
        $query = $query->whereIn('id',$request->mapel_list);

        if($request->has('kelas'))
        $query = $query->where('kelas',$request->kelas);


        return DataTables::of($query)
        ->make(true);
    }

    function data_perkelas(Request $request) {
        $user = $request->user();
        $nilaiList = NilaiSiswa::where('kelas_id',$request->kelas_id)
        ->groupBy('mapel_id');
        return DataTables::of($nilaiList)
        ->addColumn('tp',function($q){
            try {
                return json_decode($q->tp_mapel,true);
            } catch (\Throwable $th) {
                return null;
            }
        })
        ->addColumn('lm',function($q){
            try {
                return json_decode($q->lm_mapel,true);
            } catch (\Throwable $th) {
                return null;
            }
        })
        ->addColumn('nama_kelas',function($q){
            return $q->kelas->nama_kelas;
        })
        ->addColumn('nama_mapel',function($q){
            return $q->mapel->nama;
        })
        ->addColumn('kategori_mapel',function($q){
            return $q->mapel->kategori;
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
            Mapel::create($input);

            return redirect()
            ->route('sekolah_sd.mapel.index')
            ->with('message', 'success|Data berhasil disimpan');
        } catch(Exception $e){
            $msg = $e->getMessage();
            return redirect()
            ->back()
            ->with('message', "error|$msg");
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
        $data['data'] = Mapel::findorfail($id);
        // $s = new SekolahSDController();
        // $data['level_kelas'] = $s->level_kelas;
        $data['level_kelas'] = [
            "1",
            "2",
            "3",
            "4",
            "5",
            "6",
            "1 CI",
            "2 CI",
            "3 CI",
            "4 CI",
            "5 CI",
            "6 CI"
        ];
        return view('sekolah_sd.input.mapel.edit',$data);
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
        try{
            $m = Mapel::findorfail($id);
            $input = $request->all();
            $m->update($input);
            return redirect()
            ->route('sekolah_sd.mapel.index')
            ->with('message', 'success|Data berhasil disimpan');
        } catch(Exception $e){
            $msg = $e->getMessage();
            return redirect()
            ->back()
            ->with('message', "error|$msg");
        }
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
            $m = Mapel::findorfail($id);
            $m->delete();
            return ['success'=>true,'msg'=>'Data berhasil dihapus'];
        } catch(Exception $e){
            $msg = $e->getMessage();
            return ['success'=>false,'msg'=>$msg];
        }
    }

    public function import(Request $request) 
    {
        $business = $request->user()->business;
        $kelas = $request->kelas;
        Excel::import(
            new MapelImport([
                'business_id'=>$business->id,
                'kategori'=>'wajib',
                'kelas'=>$kelas
            ]), 
            request()->file('import_file')
        );
        return redirect()
        ->route('sekolah_sd.mapel.index',['kelas'=>$kelas])
        ->with('success', 'All good!');
    }

    function applyKelas(Request $request){
        $kelas = $request->kelas;
        $kelasSiswa = KelasSiswa::whereHas('kelas',function($q) use($request,$kelas){
            $q->where([
                'tahun_ajaran'=>$request->tahun_ajaran,
                'semester'=>$request->semester,
                'kelas'=>$kelas,
            ]);
        })->get();
        $n = NilaiSiswa::whereHas('kelas',function($q) use($request){
            $q->where([
                'tahun_ajaran'=>$request->tahun_ajaran,
                'semester'=>$request->semester,
                'kelas'=>$request->kelas,
            ]);
        })->delete();
        // })->count();
        // dd($n,$kelasSiswa->count());
        foreach($kelasSiswa as $k => $item){
            // dd($item);
            $kelas = new KelasController();
            $kelas->storeKelasMapel($item,$item->kelas->kelas);
        }
        return redirect()
        ->route('sekolah_sd.mapel.index',['kelas'=>$kelas])
        ->with('success', 'All good!');
    }
}
