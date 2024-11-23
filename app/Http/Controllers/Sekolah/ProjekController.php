<?php

namespace App\Http\Controllers\Sekolah;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Sekolah\FaseDimensi;
use App\Models\Sekolah\RaporProjek;
use App\Models\Sekolah\RaporDimensiProjek;
use App\Models\Sekolah\DimensiProjek;
use App\Models\Sekolah\DataDimensiID;
use App\Models\Sekolah\Kelas;
use App\Models\Sekolah\KelasSiswa;

use \App\Imports\ProjekImport;
use Excel;
use DataTables;

class ProjekController extends Controller
{
    function import_dimensi_projek(Request $request){
        $business = $request->user()->business;
        Excel::import(
            new ProjekImport(), 
            request()->file('import_file')
        );
        
        return redirect()
        ->back()
        ->with('success', 'All good!');
    }

    function data_dimensi_projek(Request $request){
        $query = FaseDimensi::with([
            'elemen' => function($q){
                return $q->select('id','elemen','dimensi_id');
            },
            'elemen.dimensi' => function($q){
                return $q->select('id','keterangan');
            },
        ]);
        return DataTables::of($query)
        ->make(true);
    }

    function rapor_projek_store(Request $request){
        $input = $request->all();
        if(isset($input['delete'])){
            switch ($input['type']) {
                case 'projek':
                    $r = RaporProjek::find($input['id']);
                    $r->delete();
                    break;
                case 'dimensi':
                    $r = RaporDimensiProjek::find($input['id']);
                    $r->delete();
                    break;
                case 'subelemen':
                    $r = RaporDimensiProjek::find($input['parent_id']);
                    $subelemen_fase = $r->subelemen_fase ?? [];
                    // dd($subelemen_fase,$r);
                    unset($subelemen_fase[$input['id']]);
                    $r->subelemen_fase = $subelemen_fase;
                    $r->save();
                    break;
            }
            return redirect()->back()
                ->with(['success'=>true,'Data berhasil di hapus']);
        }
        switch ($input['action']) {
            case 'add_project':
                RaporProjek::create($input);
                return redirect()->back()
                ->with(['success'=>true,'Data berhasil di buat']);
                break;
            case 'add_dimensi':
                $dimensi = DataDimensiID::find($input['dimensi_id']);
                RaporDimensiProjek::create([
                    'rapor_projek_id'=>$input['projek_id'],
                    'dimensi_id'=>$input['dimensi_id'],
                    'dimensi_text'=>$dimensi->keterangan
                ]);
                return redirect()->back()
                ->with(['success'=>true,'Data berhasil di buat']);
                break;
            case 'add_subelemen':
                $dimensi = FaseDimensi::find($input['subelemen_id']);
                $rapordimensi = RaporDimensiProjek::where([
                    'rapor_projek_id'=>$input['projek_id'],
                    'dimensi_id'=>$input['dimensi_id']
                ])->first();
                $subelemen_fase = $rapordimensi->subelemen_fase ?? [];
                $subelemen_fase[] = [
                    'id'=>$input['subelemen_id'],
                    'text'=>$dimensi->subelemen,
                    'target'=>$input['target_capaian']
                ];
                // $rapordimensi->subelemen_fase = json_encode($subelemen_fase);
                $rapordimensi->subelemen_fase = $subelemen_fase;
                $rapordimensi->save();
                return redirect()->back()
                ->with(['success'=>true,'Data berhasil di buat']);
                break;
            
            default:
                return redirect()->back();
                break;
        }
    }

    function fase_dimensi_data(Request $request){
        $fase = FaseDimensi::query();
        if($request->dimensi_id){
            $fase = $fase->whereHas('elemen.dimensi',function($q) use($request){
                return $q->where('id',$request->dimensi_id);
            });
        }
        return $fase->get();
    }

    function applyProjek(Request $request){

        $raporProjek = RaporProjek::where('kelas',$request->kelas)
        ->with('dimensi')
        ->get();

        // dd($raporProjek->toArray());


        $kelasList = Kelas::where([
            'tahun_ajaran' => $request->tahun_ajaran,
            'kelas' => $request->kelas,
        ])->get();
        // dd($kelasList,$request->all());
        foreach ($kelasList as $key => $value) {
            // dd($raporProjek->toArray());
            $value->dimensi_list = $raporProjek->toArray();
            // $value->dimensi_list = json_encode($raporProjek->toArray());
            // dd($value->dimensi_list);
            $value->save();
        }
        // return ['status'=>];
        return redirect()->back()
                ->with(['success'=>true,'Data berhasil dikaitkan']);
    }

    function data_rapor_projek(Request $request){
        $kelas = Kelas::where('id',2)->first();
        $query = KelasSiswa::where('kelas_id',$kelas->id);
        return DataTables::of($query)->make(true);
    }

    function storeNilai(Request $request){
        $dimensi = $request->dimensi ?? [];
        $projek = [
            'projek_id'=>$request->projek_id,
            'projek_nama'=>$request->projek_id,
            'dimensi'=>$dimensi
        ];
        $k = KelasSiswa::findorfail($request->kelas_siswa_id);
        $nilai_project = $k->nilai_project ?? [];
        if(count($nilai_project) > 0){
            foreach($nilai_project as $k => $item){
                if($item['projek_id'] == $projek['projek_id']){
                    $nilai_project[$k] = $projek;
                    break;
                }
            }
        } else {
            $nilai_project[] = $projek;
        }
        // dd($nilai_project);
        $k->nilai_projek = $nilai_project;
        $k->save();
        return redirect()->back()
                ->with(['success'=>true,'Data berhasil dikaitkan']);
    }
}
