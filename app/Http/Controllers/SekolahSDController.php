<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \App\Models\Sekolah\TenagaPendidik;
use \App\Models\Sekolah\Kelas;
use \App\Models\Sekolah\Siswa;
use \App\Models\Sekolah\NilaiSiswa;
use \App\Models\Sekolah\Mapel;
use \App\Models\Sekolah\KelasSiswa;
use \App\Models\Sekolah\Ekstrakurikuler;
use \App\Models\Sekolah\EkskulSiswa;
use \App\Models\Sekolah\NotifikasiSekolah;
use \App\Models\Sekolah\JurnalKelas;
use \App\Models\Sekolah\RaporProjek;
use \App\Models\Sekolah\DimensiProjek;
use \App\Models\Sekolah\DataDimensiID;
use \App\Models\Sekolah\PPDBSekolah;
use \App\Models\Sekolah\PPDBSetting;
use \App\Models\Sekolah\PpdbTestSchedule;
use \App\User;
use \App\Visitor;

use Spatie\Permission\Models\Role;
use App\Helpers\Helper;
use DB;
use Log;
use Str;
use DataTables;
use Storage;
use Mail;
use Carbon;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PPDBExport;
use Illuminate\Support\Facades\Password;


class SekolahSDController extends Controller
{

    public $level_kelas = [
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

    function dashboard(Request $request){
        $data['tahun_ajaran'] = Kelas::getGroupBy('tahun_ajaran');
        $data['semester'] = Kelas::getGroupBy('semester');
        return view('sekolah_sd.dashboard',$data);
    }
    
    function kelas_index(Request $request){
        $user = $request->user();
        $data['level_kelas'] = $this->level_kelas;
        $data['kelas_perwalian'] = [];
        $data['selected'] = null;
        if($user->checkGuruWalikelas()){
            $data['kelas_perwalian'] = Kelas::where('wali_kelas_id',$user->id)
            ->orderBy('id', 'desc')
            ->get()
            ->pluck('id')
            ->toArray();
            // Log::info(json_encode($data['kelas_perwalian']));
            $data['selected'] = Kelas::where('wali_kelas_id',$user->id)
            ->orderBy('id', 'desc')
            ->first();
        }
        return view('sekolah_sd.ruang_kelas',$data);
    }
    function jurnal_kelas(Request $request){
        $user = $request->user();
        if($user->checkGuruMapel() || $user->checkGuruWalikelas()){
            $list = $user->tendik->mapel_list();
            $mapel = Mapel::whereIn('id',$list)->get();
            $data['mapel'] = Mapel::whereIn('id',$list)
            ->groupBy('nama')
            ->get();
            
            $kelas_khusus = $user->tendik->kelas_khusus ?? [];
            $data['list_kelas'] = [];
            foreach($kelas_khusus as $item){
                foreach($item as $val){
                    if(!in_array($val,$data['list_kelas'])){
                        $data['list_kelas'][] = $val;
                    }
                }
            }
            // dd($data['list_kelas']);
            $data['kelas'] = Kelas::whereIn('id',$data['list_kelas'])
            ->orderBy('id','desc')
            ->get();

        } else {
            $mapel = Mapel::all();
            $data['mapel'] = Mapel::groupBy('nama')->get();
            // $data['list_kelas'] = [1,2,3,4,5,6];
            $data['list_kelas'] = $this->level_kelas;
            $data['kelas'] = Kelas::whereIn('kelas',$data['list_kelas'])
            ->orderBy('id','desc')
            ->get();
        }

        $data['tgl'] = \Carbon\Carbon::now()->format('Y-m-d');
        return view('sekolah_sd.jurnal_kelas',$data);
    }

    function data_siswa_index(Request $request){
        return view('sekolah_sd.siswa');
    }
    function data_siswa_create(Request $request){
        return view('sekolah_sd.input.siswa.create');
    }
    
    function data_mapel_index(Request $request){

        $user = $request->user();
        
        $data['mapel_id_list'] = [];
        // $data['kelas'] = [1,2,3,4,5,6];
        $data['kelas'] = $this->level_kelas;

        if($user->checkGuruMapel() || $user->checkGuruWalikelas()){
            $data['mapel_id_list'] = json_decode($user->tendik->mapel_id_list ?? "[]",true);
            if(empty($data['mapel_id_list'])) $data['mapel_id_list'] = [];
            $mapel = Mapel::whereIn('id',$data['mapel_id_list'])
            ->groupBy('kelas')
            ->get();
            $kelas = [];
            foreach($mapel as $item){
                $kelas[] = $item->kelas;
            }
            $data['kelas'] = $kelas;
        }

        $data['kelas_wali'] = [];
        if($user->checkGuruWalikelas()){
            $data['kelas_wali'] = Kelas::where('wali_kelas_id',$user->id)->get();
        }
        if($user->checkAdmin()){
            $data['kelas_wali'] = Kelas::orderByDesc('id')->get();
        }


        $data['tahun_ajaran'] = Kelas::getGroupBy('tahun_ajaran');
        $data['semester'] = Kelas::getGroupBy('semester');

        return view('sekolah_sd.mapel',$data);
    }
    function data_mapel_create(Request $request){
        $data['level_kelas'] = $this->level_kelas;
        return view('sekolah_sd.input.mapel.create');
    }
    
    function data_rekap_nilai_index(Request $request){
        
        $filter = $request->all();

        $data['filter'] = $filter;

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
                // Log::info("check kelas >> ".json_encode($kelas));
            }
        }

        $user = $request->user();
        if(
            $user->checkGuruMapel() ||
            $user->checkGuruWaliKelas()
        ){

            $data['mapel_id_list'] = json_decode($user->tendik->mapel_id_list ?? "[]",true);
            if(empty($data['mapel_id_list'])) $data['mapel_id_list'] = [];
            
            $data['mapel'] = Mapel::whereIn('id',$data['mapel_id_list'])
            ->groupBy('nama')
            ->get();

            $kelasQuery = Kelas::whereIn('id',$user->tendik->getUniqKelasKhusus())->get();
            $data['tahun_ajaran'] = $kelasQuery->groupBy('tahun_ajaran')->keys();
            $data['nama_kelas'] = $kelasQuery->groupBy('nama_kelas')->keys();
            $data['semester'] = $kelasQuery->groupBy('semester')->keys();

        }  else {

            $data['mapel'] = Mapel::groupBy('nama')->get();
            $data['tahun_ajaran'] = Kelas::getGroupBy('tahun_ajaran');
            $data['semester'] = Kelas::getGroupBy('semester');
            $data['nama_kelas'] = Kelas::getGroupBy('nama_kelas');
        }

        if(
            empty($data['tahun_ajaran']) ||
            empty($data['semester']) ||
            empty($data['nama_kelas']) ||
            empty($data['mapel'])
        ){
            return redirect()
            ->route('sekolah_sd.dashboard')
            ->with(['success'=>false,'Silahkan lengkapi data kelas & mapel terlebih dahulu']);
        }

        $filter['tahun_ajaran'] = $filter['tahun_ajaran'] ?? $data['tahun_ajaran']->first();
        $filter['semester'] = $filter['semester'] ?? $data['semester']->first();
        $filter['nama_kelas'] = $filter['nama_kelas'] ?? $data['nama_kelas']->first();

        $data['mapel_choices'] = Mapel::first();
        if(isset($filter['mapel_id'])){
            $data['mapel_choices'] = Mapel::where('nama','like',"%".$filter['mapel_id']."%");
            if(!empty($kelas)){
                $data['mapel_choices'] = $data['mapel_choices']->where('kelas',$kelas->kelas);
            }
            $data['mapel_choices'] = $data['mapel_choices']->first();
        }

        $data['list_data'] = NilaiSiswa::with([
            'siswa'=>function($q){
                return $q->select('id','nama');
            },
        ])
        ->where([
            'mapel_id'=> $data['mapel_choices']->id ?? 0,
        ]);

        if(!empty($kelas)){
            $data['list_data'] = $data['list_data']->where('kelas_id',$kelas->id);
        }
        
        $data['list_data'] = $data['list_data']->first();

        $tp_mapel = "[]";

        if( !empty($data['list_data'])){
            $tp_mapel = $data['list_data']->tp_mapel;
        }
        try{
            $data['tp'] = json_decode($tp_mapel,true);
            if(empty($data['tp'])) $data['tp'] = [];
        }catch(Exception $e){
            $data['tp'] = [];
        }

        return view('sekolah_sd.rekap_nilai_formatif',$data);
    }

    function data_rekap_nilai_sumatif_index(Request $request){
        
        $filter = $request->all();

        $data['filter'] = $filter;

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
        
        $user = $request->user();
        if(
            $user->checkGuruMapel() ||
            $user->checkGuruWaliKelas()
        ){

            $data['mapel_id_list'] = json_decode($user->tendik->mapel_id_list ?? "[]",true);
            if(empty($data['mapel_id_list'])) $data['mapel_id_list'] = [];
            // $data['mapel'] = Mapel::whereIn('id',$data['mapel_id_list'])
            // ->groupBy('kelas')
            // ->get();

            $data['mapel'] = Mapel::whereIn('id',$data['mapel_id_list'])
            ->groupBy('nama')
            ->get();

            $kelasQuery = Kelas::whereIn('id',$user->tendik->getUniqKelasKhusus())->get();
            $data['tahun_ajaran'] = $kelasQuery->groupBy('tahun_ajaran')->keys();
            $data['nama_kelas'] = $kelasQuery->groupBy('nama_kelas')->keys();
            $data['semester'] = $kelasQuery->groupBy('semester')->keys();

        } else {

            $data['mapel'] = Mapel::groupBy('nama')->get();

            $data['tahun_ajaran'] = Kelas::getGroupBy('tahun_ajaran');
            $data['semester'] = Kelas::getGroupBy('semester');
            $data['nama_kelas'] = Kelas::getGroupBy('nama_kelas');
        }

        if(
            empty($data['tahun_ajaran']) ||
            empty($data['semester']) ||
            empty($data['nama_kelas']) ||
            empty($data['mapel'])
        ){
            return redirect()
            ->route('sekolah_sd.dashboard')
            ->with(['success'=>false,'Silahkan lengkapi data kelas & mapel terlebih dahulu']);
        }

        $filter['tahun_ajaran'] = $filter['tahun_ajaran'] ?? $data['tahun_ajaran']->first();
        $filter['semester'] = $filter['semester'] ?? $data['semester']->first();
        $filter['nama_kelas'] = $filter['nama_kelas'] ?? $data['nama_kelas']->first();

        $data['mapel_choices'] = Mapel::first();
        if(isset($filter['mapel_id'])){
            $data['mapel_choices'] = Mapel::where('nama','like',"%".$filter['mapel_id']."%");
            if(!empty($kelas)){
                $data['mapel_choices'] = $data['mapel_choices']->where('kelas',$kelas->kelas);
            }
            $data['mapel_choices'] = $data['mapel_choices']->first();
        }

        $data['list_data'] = NilaiSiswa::with([
            'siswa'=>function($q){
                return $q->select('id','nama');
            },
        ])
        ->where([
            'mapel_id'=> $data['mapel_choices']->id ?? 0
        ]);

        if(!empty($kelas)){
            $data['list_data'] = $data['list_data']->where('kelas_id',$kelas->id);
        }

        $data['list_data'] = $data['list_data']->first();


        $tp_mapel = "[]";
        if( !empty($data['list_data'])){
            $tp_mapel = $data['list_data']->lm_mapel;
        }
        try{
            $data['lm'] = json_decode($tp_mapel,true);
            if(empty($data['lm'])) $data['lm'] = [];
        }catch(Exception $e){
            $data['lm'] = [];
        }
        
        return view('sekolah_sd.rekap_nilai_sumatif',$data);
    }

    function data_ekskul_index(Request $request){
        return view('sekolah_sd.ekstrakurikuler');
    }
    function data_ekskul_create(Request $request){
        return view('sekolah_sd.input.ekskul.create');
    }

    function data_tendik_index(Request $request){
        return view('sekolah_sd.tendik');
    }
    function data_tendik_create(Request $request){
        return view('sekolah_sd.input.tendik.create');
    }

    function data_rekap_absen_index(Request $request){
        $data['kelas'] = Kelas::orderBy('id','desc')->get();
        $user = auth()->user();
        if($user->checkGuruWalikelas()){
            $data['kelas'] = Kelas::where('wali_kelas_id',$user->id)->get();
        }
        return view('sekolah_sd.rekap_absen',$data);
    }

    function buku_induk_index(Request $request){
        return view('sekolah_sd.buku_induk');
    }
    function buku_induk_create(Request $request){
        return view('sekolah_sd.input.buku_induk.create');
    }

    function project_index(Request $request){
        $kelas = Kelas::find($request->kelas_id);
        $data['level_kelas'] = $this->level_kelas;
        $data['kelas'] = $kelas;
        $data['dimensi_list'] = [];
        if(!empty($kelas) && $request->has('index_projek')){
            $data['dimensi_list'] = $kelas->dimensi_list[$request->index_projek];
        }
        $data['kelas_siswa'] = KelasSiswa::where('kelas_id',$request->kelas_id)
        ->get();
        $data['index_projek'] = $request->index_projek ?? 0;
        return view('sekolah_sd.project',$data);
    }

    function kokurikuler_index(Request $request){
        $kelas = Kelas::find($request->kelas_id);
        $data['level_kelas'] = $this->level_kelas;
        $data['kelas'] = $kelas;
        $data['tema_kokurikuler'] = [];
        if(!empty($kelas) && $request->has('index_projek')){
            $data['tema_kokurikuler'] = $kelas->tema_kokurikuler[$request->index_projek];
        }
        $data['kelas_siswa'] = KelasSiswa::where('kelas_id',$request->kelas_id)
        ->get();
        $data['index_projek'] = $request->index_projek ?? 0;
        return view('sekolah_sd.kokurikuler',$data);
    }

    function project_create(Request $request){
        return view('sekolah_sd.input.project.create');
    }

    // function raport_tengah_index(Request $request){
    //     return view('sekolah_sd.raport_tengah');
    // }
    function raport_tengah_index(Request $request){

        $filter = $request->all();

        $data['business'] = $request->user()->business;
        $data['location'] = $data['business']->locations[0];
        // $data['alamat'] = $data['location']->getLocationAddressAttribute();
        $data['alamat'] = "Jalan Jendral Ahmad Yani";
        // dd($data);

        $data['tahun_ajaran'] = Kelas::getGroupBy('tahun_ajaran');
        $data['semester'] = Kelas::getGroupBy('semester');
        $data['nama_kelas'] = Kelas::getGroupBy('nama_kelas');

        $kelas = Kelas::first();
        $siswa = Siswa::first();

        $data['kelas_siswa'] = KelasSiswa::where([
            'kelas_id'=> $kelas->id,
            'siswa_id'=> $siswa->id,
        ])
        ->with('kelas','siswa')
        ->first();

        if(empty($data['kelas_siswa'])){
            $data['kelas_siswa'] = KelasSiswa::first();
            if(empty($data['kelas_siswa'])){
                return redirect()->route('sekolah_sd.kelas.index')
                ->with(['success'=>false,'message'=>"Silahkan tambah kelas siswa terlebih dahulu"]);
            }
        }

        

        // dd($data['kelas_siswa']);

        $data['nilai_list'] = NilaiSiswa::where([
            'kelas_id'=> $data['kelas_siswa']->kelas_id,
            'siswa_id'=> $data['kelas_siswa']->siswa_id,
        ])
        ->with('mapel')
        ->get();
        // dd($data['nilai_list']);

        return view('sekolah_sd.raport_tengah',$data);
    }
    function raport_akhir_index(Request $request){

        $filter = $request->all();

        $data['business'] = $request->user()->business;
        $data['location'] = $data['business']->locations[0];
        // $data['alamat'] = $data['location']->getLocationAddressAttribute();
        $data['alamat'] = "Jalan Jendral Ahmad Yani";
        $data['ekskul'] = Ekstrakurikuler::orderBy('id','desc')->get();

        $user = $request->user();
        if($user->checkGuruWalikelas()){
            $kelas = Kelas::where('wali_kelas_id',$user->id)->get();
            $data['tahun_ajaran'] = $kelas->groupBy('tahun_ajaran')->keys();
            $data['semester'] = $kelas->groupBy('semester')->keys();
            $data['nama_kelas'] = $kelas->groupBy('nama_kelas')->keys();
        } else {
            $data['tahun_ajaran'] = Kelas::getGroupBy('tahun_ajaran');
            $data['semester'] = Kelas::getGroupBy('semester');
            $data['nama_kelas'] = Kelas::getGroupBy('nama_kelas');
        }

        $data['kelas_siswa'] = null;
        $data['nilai_list'] = [];
        if($request->has('kelas_id')){
            $data['kelas_siswa'] = KelasSiswa::find($request->kelas_id);
        }

        if(empty($data['kelas_siswa'])){
            return view('sekolah_sd.raport_akhir',$data)
            ->with(['success'=>false,'message'=>"Data kelas anda kosong"]);
        }

        $data['nilai_list'] = NilaiSiswa::where([
            'kelas_id'=> $data['kelas_siswa']->kelas_id,
            'siswa_id'=> $data['kelas_siswa']->siswa_id,
        ])
        // ->whereHas('mapel')
        ->join('mapels', 'mapels.id', '=', 'nilai_siswas.mapel_id')
        ->orderBy('mapels.orders','asc')
        ->with('mapel')
        ->get();

        // dd($data['nilai_list']->toArray());
        
        $data['fase'] = null;
        $kelas = $data['kelas_siswa']->kelas;
        if($kelas->kelas > 0 && $kelas->kelas <=2){
            $data['fase'] = "A";
        }
        if($kelas->kelas > 2 && $kelas->kelas <=4){
            $data['fase'] = "B";
        }
        if($kelas->kelas > 4 && $kelas->kelas <=6){
            $data['fase'] = "C";
        }

        // Urutan ranking nilai kokurikuler
        // $ranking = ["SB" => 4, "B" => 3, "C" => 2, "K" => 1];
        // $descrip = ["SB" => "sangat baik", "B" => "baik", "C" => "cukup", "K" => "kurang"];
        $ranking = ["M" => 3, "C" => 2, "B" => 1];
        $descrip = ["M" => "mahir", "C" => "cakap", "B" => "berkembang"];

        $nilai_kokurikuler = $data['kelas_siswa']->nilai_kokurikuler ?? [];
        $nama_siswa = $data['kelas_siswa']->siswa->nama ?? "";

        try {
            foreach ($nilai_kokurikuler as $key => $value) {
    
                // $nilai_tertinggi = collect($value['dimensi'])
                // ->sortByDesc(fn($d) => $ranking[$d['nilai']])
                // ->first();
        
                // $nilai_terendah = collect($value['dimensi'])
                // ->sortBy(fn($d) => $ranking[$d['nilai']])
                // ->first();
    
                // $tema = $value['kokurikuler_tema'] ?? '';
                // $min = strtolower($nilai_terendah['nama'] ?? '');
                // $max = strtolower($nilai_tertinggi['nama'] ?? '');
                // $min_desc = $descrip[$nilai_terendah['nilai']] ?? '';
                // $max_desc = $descrip[$nilai_tertinggi['nilai']] ?? '';
    
                // $nilai_kokurikuler[$key]['kokurikuler_desc'] = "";
                // dd(
                //     count($value['dimensi']),
                //     $value['dimensi']
                // );
                // if( count($value['dimensi']) == 1){
                //     $nilai_kokurikuler[$key]['kokurikuler_desc'] = "$nama_siswa sudah $max_desc dalam aspek $max pada tema $tema";
                // }
                // if( count($value['dimensi']) > 1){
                //     $nilai_kokurikuler[$key]['kokurikuler_desc'] = "$nama_siswa sudah $max_desc dalam aspek $max serta $min_desc dalam aspek $min pada tema $tema";
                // }
    
                $tema = $value['kokurikuler_tema'] ?? '';
                $dimensi = collect($value['dimensi']);
                $nilai_unik = $dimensi->pluck('nilai')->unique();

    
                if ($nilai_unik->count() === 1) {
                    // Semua nilai sama
                    $nilai = $nilai_unik->first(); // M / C / B
                    $nilai_desc = $descrip[$nilai] ?? '';
    
                    $aspek_list = $dimensi->pluck('nama')->map(fn($n) => $n)->implode(' dan ');
    
                    $nilai_kokurikuler[$key]['kokurikuler_desc'] =
                        "$nama_siswa sudah $nilai_desc dalam aspek $aspek_list pada tema $tema";
                } else {
                    // Ada nilai tertinggi & terendah berbeda (logika lama)
                    $nilai_tertinggi = $dimensi->sortByDesc(fn($d) => $ranking[$d['nilai']])->first();
                    $nilai_terendah = $dimensi->sortBy(fn($d) => $ranking[$d['nilai']])->first();
    
                    $min = $nilai_terendah['nama'] ?? '';
                    $max = $nilai_tertinggi['nama'] ?? '';
                    $min_desc = $descrip[$nilai_terendah['nilai']] ?? '';
                    $max_desc = $descrip[$nilai_tertinggi['nilai']] ?? '';

                    if ($dimensi->count() === 1) {
                        $nilai_kokurikuler[$key]['kokurikuler_desc'] =
                            "$nama_siswa sudah $max_desc dalam aspek $max pada tema $tema";
                    } else {
                        $nilai_kokurikuler[$key]['kokurikuler_desc'] =
                            "$nama_siswa sudah $max_desc dalam aspek $max serta $min_desc dalam aspek $min pada tema $tema";
                    }
                }
    
            }
        } catch (\Throwable $th) {
            Log::info("Error raport akhir index :".$th->getMessage());
            Log::info(json_encode($data));
        }

        $data['nilai_kokurikuler'] = $nilai_kokurikuler;

        // @NAMA@ sudah @NILAIMAX@ dalam @DIMENSI@ dan masih perlu berlatih dalam @NILAIMIN@ dalam tema @TEMA@

        //  if( 
        //     $data['kelas_siswa']->siswa->nisn == "0153381467"
        //  ){

        //     $nilai_list = NilaiSiswa::where([
        //         'kelas_id'=> $data['kelas_siswa']->kelas_id,
        //     ])
        //     ->whereHas('mapel',function($q){
        //         $q->where('nama',"Matematika")
        //         ->where('kelas','!=','3 CI');
        //     })
        //     ->join('mapels', 'mapels.id', '=', 'nilai_siswas.mapel_id')
        //     ->delete();

        //     // foreach($nilai_list as $item){
        //     //     $item->delete();
        //     // }

        //     Log::info("OK");
        //     // Log::info("row affected >> ". $nilai_list->count() );
        // //     // Log::info("nilai_list >> ". $nilai_list );
        // //     // Log::info("nilai_list >> ". json_encode($nilai_list) );
        // }

        return view('sekolah_sd.raport_akhir',$data);
    }

    function raport_akhir_print(Request $request, Int $id){

        $data['kelas_siswa'] = KelasSiswa::findorfail($id);
        $user = $request->user();
        if(empty($user)){
            $token = $request->token ?? "-1";
            $token  = hash('sha256', $token);
            $user = \App\User::where('api_token',$token)->firstorfail();
        }
        $data['business'] = $user->business;
        $data['location'] = $data['business']->locations[0];
        // $data['alamat'] = $data['location']->getLocationAddressAttribute();
        $data['alamat'] = "Jalan Jendral Ahmad Yani";

        if(empty($data['kelas_siswa'])){
            return redirect()->route('sekolah_sd.kelas.index')
            ->with(['success'=>false,'message'=>"Silahkan tambah kelas siswa terlebih dahulu"]);
        }

        $data['fase'] = null;
        $kelas = $data['kelas_siswa']->kelas;
        if($kelas->kelas > 0 && $kelas->kelas <= 2){
            $data['fase'] = "A";
        }
        if($kelas->kelas > 2 && $kelas->kelas <= 4){
            $data['fase'] = "B";
        }
        if($kelas->kelas > 4 && $kelas->kelas <= 6){
            $data['fase'] = "C";
        }

        $where = [
            'kelas_id'=> $data['kelas_siswa']->kelas_id,
            'siswa_id'=> $data['kelas_siswa']->siswa_id,
        ];

        $data['nilai_list'] = NilaiSiswa::where($where)
        // ->whereHas('mapel')
        ->join('mapels', 'mapels.id', '=', 'nilai_siswas.mapel_id')
        ->orderBy('mapels.orders','asc')
        ->with('mapel')
        ->get();

        $data['ekskul_siswa'] = EkskulSiswa::where($where)
        ->with('ekskul')
        ->get();

        $lvlkelas = $kelas->kelas;
        $lvlkelas = preg_replace('/\D+/', '', $lvlkelas);
        $lvlkelas = $lvlkelas+1;
        // Log::info("kelas >> ". $kelas->kelas." -> ". $lvlkelas);

        $data['naik_kelas'] = angkaKeRomawi( $lvlkelas ). " (".ucfirst( angkaKeHuruf($lvlkelas) ).")";

        // Urutan ranking nilai kokurikuler
        // $ranking = ["SB" => 4, "B" => 3, "C" => 2, "K" => 1];
        // $descrip = ["SB" => "sangat baik", "B" => "baik", "C" => "cukup", "K" => "kurang"];
        $ranking = ["M" => 3, "C" => 2, "B" => 1];
        $descrip = ["M" => "mahir", "C" => "cakap", "B" => "berkembang"];

        $nilai_kokurikuler = $data['kelas_siswa']->nilai_kokurikuler ?? [];
        $nama_siswa = $data['kelas_siswa']->siswa->nama ?? "";

        try {
            foreach ($nilai_kokurikuler as $key => $value) {
    
                // $nilai_tertinggi = collect($value['dimensi'])
                // ->sortByDesc(fn($d) => $ranking[$d['nilai']])
                // ->first();
        
                // $nilai_terendah = collect($value['dimensi'])
                // ->sortBy(fn($d) => $ranking[$d['nilai']])
                // ->first();
    
                // $tema = $value['kokurikuler_tema'] ?? '';
                // $min = strtolower($nilai_terendah['nama'] ?? '');
                // $max = strtolower($nilai_tertinggi['nama'] ?? '');
                // $min_desc = $descrip[$nilai_terendah['nilai']] ?? '';
                // $max_desc = $descrip[$nilai_tertinggi['nilai']] ?? '';
    
                // $nilai_kokurikuler[$key]['kokurikuler_desc'] = "";
                // dd(
                //     count($value['dimensi']),
                //     $value['dimensi']
                // );
                // if( count($value['dimensi']) == 1){
                //     $nilai_kokurikuler[$key]['kokurikuler_desc'] = "$nama_siswa sudah $max_desc dalam aspek $max pada tema $tema";
                // }
                // if( count($value['dimensi']) > 1){
                //     $nilai_kokurikuler[$key]['kokurikuler_desc'] = "$nama_siswa sudah $max_desc dalam aspek $max serta $min_desc dalam aspek $min pada tema $tema";
                // }
    
                $tema = $value['kokurikuler_tema'] ?? '';
                $dimensi = collect($value['dimensi']);
                $nilai_unik = $dimensi->pluck('nilai')->unique();
    
                if ($nilai_unik->count() === 1) {
                    // Semua nilai sama
                    $nilai = $nilai_unik->first(); // M / C / B
                    $nilai_desc = $descrip[$nilai] ?? '';
    
                    $aspek_list = $dimensi->pluck('nama')->map(fn($n) => $n)->implode(' dan ');
    
                    $nilai_kokurikuler[$key]['kokurikuler_desc'] =
                        "$nama_siswa sudah $nilai_desc dalam aspek $aspek_list pada tema $tema";
                } else {
                    // Ada nilai tertinggi & terendah berbeda (logika lama)
                    $nilai_tertinggi = $dimensi->sortByDesc(fn($d) => $ranking[$d['nilai']])->first();
                    $nilai_terendah = $dimensi->sortBy(fn($d) => $ranking[$d['nilai']])->first();
    
                    $min = $nilai_terendah['nama'] ?? '';
                    $max = $nilai_tertinggi['nama'] ?? '';
                    $min_desc = $descrip[$nilai_terendah['nilai']] ?? '';
                    $max_desc = $descrip[$nilai_tertinggi['nilai']] ?? '';

                    if ($dimensi->count() === 1) {
                        $nilai_kokurikuler[$key]['kokurikuler_desc'] =
                            "$nama_siswa sudah $max_desc dalam aspek $max pada tema $tema";
                    } else {
                        $nilai_kokurikuler[$key]['kokurikuler_desc'] =
                            "$nama_siswa sudah $max_desc dalam aspek $max serta $min_desc dalam aspek $min pada tema $tema";
                    }
                }
    
            }
        } catch (\Throwable $th) {
            Log::info("Error raport akhir index :".$th->getMessage());
        }


        $data['nilai_kokurikuler'] = $nilai_kokurikuler;

        return view('sekolah_sd.prints.akhir',$data);
    }

    function raport_project_print(Request $request, Int $id){

        $data['kelas_siswa'] = KelasSiswa::findorfail($id);
        $user = $request->user();
        if(empty($user)){
            $token = $request->token ?? "-1";
            $token  = hash('sha256', $token);
            $user = \App\User::where('api_token',$token)->firstorfail();
        }
        $data['business'] = $user->business;
        $data['location'] = $data['business']->locations[0];
        // $data['alamat'] = $data['location']->getLocationAddressAttribute();
        $data['alamat'] = "Jalan Jendral Ahmad Yani";

        $where = [
            'kelas_id'=> $data['kelas_siswa']->kelas_id,
            'siswa_id'=> $data['kelas_siswa']->siswa_id,
        ];

        $data['fase'] = null;
        $kelas = $data['kelas_siswa']->kelas;
        if($kelas->kelas > 0 && $kelas->kelas <=2){
            $data['fase'] = "A";
        }
        if($kelas->kelas > 2 && $kelas->kelas <=4){
            $data['fase'] = "B";
        }
        if($kelas->kelas > 4 && $kelas->kelas <=6){
            $data['fase'] = "C";
        }

        $data['kelas_siswa']->nilai_projek = !empty($data['kelas_siswa']->nilai_projek) ? 
        collect($data['kelas_siswa']->nilai_projek)->sortBy('projek_id')->values() : 
        $data['kelas_siswa']->nilai_projek;

        return view('sekolah_sd.prints.project',$data);
    }

    function raport_tengah_print(Request $request, Int $id){
        
        $data['kelas_siswa'] = KelasSiswa::findorfail($id);

        $data['business'] = $request->user()->business;
        $data['location'] = $data['business']->locations[0];
        // $data['alamat'] = $data['location']->getLocationAddressAttribute();
        $data['alamat'] = "Jalan Jendral Ahmad Yani";

        if(empty($data['kelas_siswa'])){
            return redirect()->route('sekolah_sd.kelas.index')
            ->with(['success'=>false,'message'=>"Silahkan tambah kelas siswa terlebih dahulu"]);
        }

        $data['nilai_list'] = NilaiSiswa::where([
            'kelas_id'=> $data['kelas_siswa']->kelas_id,
            'siswa_id'=> $data['kelas_siswa']->siswa_id,
        ])
        ->with('mapel')
        ->get();

        return view('sekolah_sd.prints.tengah',$data);
    }

    function create_role_sekolah(Request $request){
        try {
            $output = ['success' => 1,
                'msg' => __("user.role_added")
            ];
            $business_id = $request->session()->get('user.business_id');
            $roleList = ['guru','admin','kepala sekolah','orang tua'];
            foreach($roleList as $key => $item){
                $count = Role::where('name', $item . '#' . $business_id)
                            ->where('business_id', $business_id)
                            ->count();
                if ($count == 0) {
                    $is_service_staff = 0;
                    if ($request->input('is_service_staff') == 1) {
                        $is_service_staff = 1;
                    }
    
                    $role = Role::create([
                                'name' => $item . '#' . $business_id ,
                                'business_id' => $business_id,
                                'is_service_staff' => $is_service_staff
                            ]);
                }
                // } else {
                //     $output = ['success' => 0,
                //                 'msg' => __("user.role_already_exists")
                //             ];
                // }
            }
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
            $output = ['success' => 0,
                            'msg' => __("messages.something_went_wrong")
                        ];
        }
        return $output;
        // return redirect('roles')->with('status', $output);
        
    }

    function kelas_siswa_api(Request $request){
        $user = request()->user();
        $siswa = Siswa::where('nisn',$user->username)->first();
        $kelas = KelasSiswa::where('siswa_id',$siswa->id)
        ->select('id','siswa_id','kelas_id')
        ->with('kelas')
        ->whereNull('deleted_at')
        ->orderBy('id','desc')
        ->get();
        // ->pluck('kelas');
        return response()->json(
            Helper::DataReturn(true,"OK",$kelas), 
        200); 
    }

    function profil_siswa_api(Request $request){
        $user = request()->user();
        $siswa = Siswa::where('nisn',$user->username)
        ->select('nisn','nama','detail','foto')
        ->first();
        return response()->json(
            Helper::DataReturn(true,"OK",$siswa), 
        200); 
    }

    // function raport_siswa_api(Request $request){
    //     $user = request()->user();
    //     $siswa = Siswa::where('nisn',$user->username)
    //     ->select('nisn','nama','detail')
    //     ->first();
    //     return response()->json(
    //         Helper::DataReturn(true,"OK",$siswa), 
    //     200); 
    // }

    function update_password(Request $request){
        $user = request()->user();
        $user->password = bcrypt($request->password);
        $user->save();
        return response()->json(
            Helper::DataReturn(true,"Password berhasil diperbarahui"), 
        200); 
    }

    function notifikasi_api(Request $request){

        $user = request()->user();

        $data = NotifikasiSekolah::where('user_id',$user->id)
        ->orderBy('id','desc')
        ->get();
        
        return response()->json(
            Helper::DataReturn(true,"OK",$data), 
        200); 
    }

    function jurnal_kelas_api(Request $request){

        $user = request()->user();

        $siswa = Siswa::where('nisn',$user->username)->first();

        $data = JurnalKelas::where('kelas_id',$request->kelas_id)
        ->where('tanggal',$request->tgl)
        ->orderBy('id','desc')
        ->get();

        $list_absen = [];

        foreach ($data as $key => $value) {
            $jurnal = [];
            try {
                $jurnal = json_decode($value->jurnal,true);
            } catch (\Throwable $th) {
                $jurnal = [];
            }
            $mapel = $value->mapel()->select('nama')->first();
            $nama_mapel = $mapel->nama ?? "";

            $list_absen[] = [
                "mapel"=>$nama_mapel,
                "status"=>$jurnal[$siswa->id] ?? "-"
            ];
        }

        
        return response()->json(
            Helper::DataReturn(true,"OK",$list_absen), 
        200); 
    }

    private function getDataTahunanSiswa($year) {
        $tahun = [$year];
        $data['list_tahun_interval'] = [];
        foreach ($tahun as $key => $value) {
            $period_tahun = [];
            $period_tahun['laki-laki'] = DB::table('siswas')
            ->select(DB::raw('COUNT(*) as total'))
            ->where('tahun_masuk', $value)
            // ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(detail, '$.jenis_kelamin')) = ?", ['Laki-Laki'])
            ->whereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(detail, '$.jenis_kelamin'))) LIKE '%laki-laki%'")
            ->first()
            ->total;
            $period_tahun['perempuan'] = DB::table('siswas')
            ->select(DB::raw('COUNT(*) as total'))
            ->where('tahun_masuk', $value)
            // ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(detail, '$.jenis_kelamin')) = ?", ['Perempuan'])
            ->whereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(detail, '$.jenis_kelamin'))) LIKE '%perempuan%'")
            ->first()
            ->total;
            $period_tahun['total'] = DB::table('siswas')
            ->select(DB::raw('COUNT(*) as total'))
            ->where('tahun_masuk', $value)
            ->first()
            ->total;
            $data['list_tahun_interval'][$value] = $period_tahun;
        }
        return $data['list_tahun_interval'];
    }

    private function getKelasSiswaTahunan($tahun_ajaran) {
        // $tahun_ajaran = Kelas::groupBy('tahun_ajaran')->get()->pluck('tahun_ajaran');
        // $tahun_ajaran = "2023/2024";
        // $kelas = [1,2,3,4,5,6];
        $kelas = $this->level_kelas;
        $agregate = [];
        foreach ($kelas as $key => $value) {
            $counter = KelasSiswa::whereHas('kelas',function($q) use($tahun_ajaran,$value){
                $q->where([
                    'tahun_ajaran'=>$tahun_ajaran,
                    'kelas'=>$value,
                ]);
            })
            ->count();
            $agregate[$value] = $counter;
        }
        // dd($agregate);
        return $agregate;
    }

    function dashboard_api(Request $request){

        $user = $request->user();

        if($user->checkGuru()){
            return [];
        }

        $data['total_siswa'] = Siswa::count();
        $data['total_tendik'] = TenagaPendidik::count();

        $data['list_jumlah_siswa_perkelas'] = $this->getKelasSiswaTahunan($request->tahun_ajaran ?? "2023/2024");
        $data['list_tahun_interval'] = $this->getDataTahunanSiswa($request->tahun ?? 2024);

        return response()->json(
            Helper::DataReturn(true,"OK",$data), 
        200); 

    }

    function dimensi_projek(Request $request){
        return view('sekolah_sd.dimensi_projek');
    }

    function skenario_projek(Request $request){
        $data['level_kelas'] = $this->level_kelas;
        $data['rapor_projek'] = [];
        $data['dimensi'] = DataDimensiID::all();
        if($request->kelas){
            $data['rapor_projek'] = RaporProjek::where('kelas',$request->kelas)->get();
        }
        $data['tahun_ajaran'] = Kelas::getGroupBy('tahun_ajaran');
        $data['semester'] = Kelas::getGroupBy('semester');
        return view('sekolah_sd.skenario_projek',$data);
    }

    function test(Request $request){
        // $business_id = $request->user()->business->id;
        // $tendik = TenagaPendidik::all();
        // foreach($tendik as $key => $value){
        //     $u = User::where('username',$value->nik)->first();
        //     if(empty($u)) {
        //         $insert_user = [
        //             'first_name'=>$value->nama,
        //             'username'=>$value->nik,
        //             'business_id'=>$business_id,
        //             'password'=> bcrypt($value->nik)
        //         ];
        //         $u = User::create($insert_user);
        //     }
        //     $value->user_id = $u->id;
        //     $value->save();
        // }
        $siswa = Siswa::all();
        foreach ($siswa as $key => $value) {
            $value->nama = ucwords(strtolower($value->nama));
            $value->save();
        }
        return count($siswa);
    }

    function rapor_project_index(Request $request){

        $filter = $request->all();

        $data['business'] = $request->user()->business;
        $data['location'] = $data['business']->locations[0];
        // $data['alamat'] = $data['location']->getLocationAddressAttribute();
        $data['alamat'] = "Jalan Jendral Ahmad Yani";
        $data['ekskul'] = Ekstrakurikuler::orderBy('id','desc')->get();

        $user = $request->user();
        if($user->checkGuruWalikelas()){
            $kelas = Kelas::where('wali_kelas_id',$user->id)->get();
            $data['tahun_ajaran'] = $kelas->groupBy('tahun_ajaran')->keys();
            $data['semester'] = $kelas->groupBy('semester')->keys();
            $data['nama_kelas'] = $kelas->groupBy('nama_kelas')->keys();
        } else {
            $data['tahun_ajaran'] = Kelas::getGroupBy('tahun_ajaran');
            $data['semester'] = Kelas::getGroupBy('semester');
            $data['nama_kelas'] = Kelas::getGroupBy('nama_kelas');
        }

        $data['kelas_siswa'] = null;
        $data['nilai_list'] = [];
        $data['fase'] = null;
        if($request->has('kelas_id')){
            $data['kelas_siswa'] = KelasSiswa::find($request->kelas_id);
            $kelas = $data['kelas_siswa']->kelas;
            if($kelas->kelas > 0 && $kelas->kelas <=2){
                $data['fase'] = "A";
            }
            if($kelas->kelas > 2 && $kelas->kelas <=4){
                $data['fase'] = "B";
            }
            if($kelas->kelas > 4 && $kelas->kelas <=6){
                $data['fase'] = "C";
            }
            // dd(collect($data['kelas_siswa']->nilai_projek));
            $data['kelas_siswa']->nilai_projek = !empty($data['kelas_siswa']->nilai_projek) ? 
            collect($data['kelas_siswa']->nilai_projek)->sortBy('projek_id')->values() : 
            $data['kelas_siswa']->nilai_projek;
        }


        return view('sekolah_sd.rapor_projek',$data);
    }

    function buku_induk_print(Request $request,$id){

        $user = $request->user();
        if(empty($user)){
            $token = $request->token ?? "-1";
            $token  = hash('sha256', $token);
            $user = \App\User::where('api_token',$token)->firstorfail();
        }

        $data['siswa'] = Siswa::findorfail($id);
        
        $data['kelas_siswa'] = KelasSiswa::where('siswa_id',$data['siswa']->id)->first();
        
        $data['business'] = $user->business;
        $data['location'] = $data['business']->locations[0];
        // $data['alamat'] = $data['location']->getLocationAddressAttribute();
        $data['alamat'] = "Jalan Jendral Ahmad Yani";

        if(empty($data['kelas_siswa'])){
            return redirect()->route('sekolah_sd.kelas.index')
            ->with(['success'=>false,'message'=>"Silahkan tambah kelas siswa terlebih dahulu"]);
        }

        $where = [
            'kelas_id'=> $data['kelas_siswa']->kelas_id,
            'siswa_id'=> $data['kelas_siswa']->siswa_id,
        ];

        $data['nilai_list'] = NilaiSiswa::where($where)
        ->with('mapel')
        ->get();

        $data['ekskul_siswa'] = EkskulSiswa::where($where)
        ->with('ekskul')
        ->get();

        return view('sekolah_sd.prints.buku_induk',$data);
    }

    function cetak_rapor_akhir_perkelas(Request $request){

        $kelas = Kelas::where([
            'tahun_ajaran'=>$request->tahun_ajaran,
            'semester'=>$request->semester,
            'nama_kelas'=>$request->kelas,
        ])->firstorfail();

        $user = $request->user();
        if(empty($user)){
            $token = $request->token ?? "-1";
            $token  = hash('sha256', $token);
            $user = \App\User::where('api_token',$token)->firstorfail();
        }
        $data['business'] = $user->business;
        $data['location'] = $data['business']->locations[0];
        // $data['alamat'] = $data['location']->getLocationAddressAttribute();
        $data['alamat'] = "Jalan Jendral Ahmad Yani";

        $kelas_siswa = KelasSiswa::where('kelas_id',$kelas->id)->get();
        $html = '';
        foreach($kelas_siswa as $k => $item){

            $where = [
                'kelas_id'=> $item->kelas_id,
                'siswa_id'=> $item->siswa_id,
            ];
    
            $data['nilai_list'] = NilaiSiswa::where($where)
            ->with('mapel')
            ->get();
    
            $data['ekskul_siswa'] = EkskulSiswa::where($where)
            ->with('ekskul')
            ->get();

            $data['kelas_siswa'] = $item;
    
            $html .= view('sekolah_sd.prints.satuan_rapor_akhir_comp',$data)->render();
        }
        $input['isi'] = $html;
        return view('sekolah_sd.prints.cetak_masal',$input);
    }

    function raport_project_print_perkelas(Request $request){

        $kelas = Kelas::where([
            'tahun_ajaran'=>$request->tahun_ajaran,
            'semester'=>$request->semester,
            'nama_kelas'=>$request->kelas,
        ])->firstorfail();

        $user = $request->user();
        if(empty($user)){
            $token = $request->token ?? "-1";
            $token  = hash('sha256', $token);
            $user = \App\User::where('api_token',$token)->firstorfail();
        }
        $data['business'] = $user->business;
        $data['location'] = $data['business']->locations[0];
        // $data['alamat'] = $data['location']->getLocationAddressAttribute();
        $data['alamat'] = "Jalan Jendral Ahmad Yani";

        $kelas_siswa = KelasSiswa::where('kelas_id',$kelas->id)->get();
        $html = '';
        foreach($kelas_siswa as $item){
            $where = [
                'kelas_id'=> $item->kelas_id,
                'siswa_id'=> $item->siswa_id,
            ];
    
            $data['fase'] = null;
            $data['kelas_siswa'] = KelasSiswa::where($where)->first();
            $kelas = $data['kelas_siswa']->kelas;
            if($kelas->kelas > 0 && $kelas->kelas <=2){
                $data['fase'] = "A";
            }
            if($kelas->kelas > 2 && $kelas->kelas <=4){
                $data['fase'] = "B";
            }
            if($kelas->kelas > 4 && $kelas->kelas <=6){
                $data['fase'] = "C";
            }
            $html .= view('sekolah_sd.prints.satu_project_comp',$data)->render();

            $item->nilai_projek = !empty($item->nilai_projek) ? 
            collect($item->nilai_projek)->sortBy('projek_id')->values() : 
            $item->nilai_projek;

        }
        $input['isi'] = $html;
        
        return view('sekolah_sd.prints.cetak_masal_project',$input);
    }

    function raport_table_index(Request $request){
        $user = $request->user();
        $data['kelas_perwalian'] = [];
        $data['selected'] = null;
        if($user->checkGuruWalikelas()){
            $data['kelas_perwalian'] = Kelas::where('wali_kelas_id',$user->id)->get()->pluck('id')->toArray();
            $data['selected'] = Kelas::where('wali_kelas_id',$user->id)->first();
        }
        return view('sekolah_sd.tabel_raport',$data);
    }

    function formatif_walikelas_index(Request $request){
        
        $filter = $request->all();

        $data['filter'] = $filter;

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

        $user = $request->user();
        if(
            $user->checkGuruMapel() ||
            $user->checkGuruWaliKelas()
        ){

            $data['mapel_id_list'] = json_decode($user->tendik->mapel_id_list ?? "[]",true);
            if(empty($data['mapel_id_list'])) $data['mapel_id_list'] = [];

            $kelasQuery = Kelas::where('wali_kelas_id',$user->id)->get();

            $kelasList = $kelasQuery->groupBy('kelas')->keys();
            // dd($kelasList);
            $data['mapel'] = Mapel::whereIn('kelas',$kelasList)
            ->groupBy('nama')
            ->get();

            $data['tahun_ajaran'] = $kelasQuery->groupBy('tahun_ajaran')->keys();
            $data['nama_kelas'] = $kelasQuery->groupBy('nama_kelas')->keys();
            $data['semester'] = $kelasQuery->groupBy('semester')->keys();

        }  else {

            $data['mapel'] = Mapel::groupBy('nama')->get();
            $data['tahun_ajaran'] = Kelas::getGroupBy('tahun_ajaran');
            $data['semester'] = Kelas::getGroupBy('semester');
            $data['nama_kelas'] = Kelas::getGroupBy('nama_kelas');
        }

        if(
            empty($data['tahun_ajaran']) ||
            empty($data['semester']) ||
            empty($data['nama_kelas']) ||
            empty($data['mapel'])
        ){
            return redirect()
            ->route('sekolah_sd.dashboard')
            ->with(['success'=>false,'Silahkan lengkapi data kelas & mapel terlebih dahulu']);
        }

        $filter['tahun_ajaran'] = $filter['tahun_ajaran'] ?? $data['tahun_ajaran']->first();
        $filter['semester'] = $filter['semester'] ?? $data['semester']->first();
        $filter['nama_kelas'] = $filter['nama_kelas'] ?? $data['nama_kelas']->first();

        $data['mapel_choices'] = Mapel::first();
        if(isset($filter['mapel_id'])){
            $data['mapel_choices'] = Mapel::where('nama','like',"%".$filter['mapel_id']."%");
            if(!empty($kelas)){
                $data['mapel_choices'] = $data['mapel_choices']->where('kelas',$kelas->kelas);
            }
            $data['mapel_choices'] = $data['mapel_choices']->first();
        }

        $data['list_data'] = NilaiSiswa::with([
            'siswa'=>function($q){
                return $q->select('id','nama');
            },
        ])
        ->where([
            'mapel_id'=> $data['mapel_choices']->id ?? 0,
        ]);

        if(!empty($kelas)){
            $data['list_data'] = $data['list_data']->where('kelas_id',$kelas->id);
        }
        
        $data['list_data'] = $data['list_data']->first();

        $tp_mapel = "[]";

        if( !empty($data['list_data'])){
            $tp_mapel = $data['list_data']->tp_mapel;
        }
        try{
            $data['tp'] = json_decode($tp_mapel,true);
            if(empty($data['tp'])) $data['tp'] = [];
        }catch(Exception $e){
            $data['tp'] = [];
        }

        return view('sekolah_sd.rekap_formatif_walikelas',$data);
    }
    
    function sumatif_walikelas_index(Request $request){
        
        $filter = $request->all();

        $data['filter'] = $filter;

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

        $user = $request->user();
        if(
            $user->checkGuruMapel() ||
            $user->checkGuruWaliKelas()
        ){

            $data['mapel_id_list'] = json_decode($user->tendik->mapel_id_list ?? "[]",true);
            if(empty($data['mapel_id_list'])) $data['mapel_id_list'] = [];

            $kelasQuery = Kelas::where('wali_kelas_id',$user->id)->get();

            $kelasList = $kelasQuery->groupBy('kelas')->keys();
            // dd($kelasList);
            $data['mapel'] = Mapel::whereIn('kelas',$kelasList)
            ->groupBy('nama')
            ->get();

            $data['tahun_ajaran'] = $kelasQuery->groupBy('tahun_ajaran')->keys();
            $data['nama_kelas'] = $kelasQuery->groupBy('nama_kelas')->keys();
            $data['semester'] = $kelasQuery->groupBy('semester')->keys();

        }  else {

            $data['mapel'] = Mapel::groupBy('nama')->get();
            $data['tahun_ajaran'] = Kelas::getGroupBy('tahun_ajaran');
            $data['semester'] = Kelas::getGroupBy('semester');
            $data['nama_kelas'] = Kelas::getGroupBy('nama_kelas');
        }

        if(
            empty($data['tahun_ajaran']) ||
            empty($data['semester']) ||
            empty($data['nama_kelas']) ||
            empty($data['mapel'])
        ){
            return redirect()
            ->route('sekolah_sd.dashboard')
            ->with(['success'=>false,'Silahkan lengkapi data kelas & mapel terlebih dahulu']);
        }

        $filter['tahun_ajaran'] = $filter['tahun_ajaran'] ?? $data['tahun_ajaran']->first();
        $filter['semester'] = $filter['semester'] ?? $data['semester']->first();
        $filter['nama_kelas'] = $filter['nama_kelas'] ?? $data['nama_kelas']->first();

        $data['mapel_choices'] = Mapel::first();
        if(isset($filter['mapel_id'])){
            $data['mapel_choices'] = Mapel::where('nama','like',"%".$filter['mapel_id']."%");
            if(!empty($kelas)){
                $data['mapel_choices'] = $data['mapel_choices']->where('kelas',$kelas->kelas);
            }
            $data['mapel_choices'] = $data['mapel_choices']->first();
        }

        $data['list_data'] = NilaiSiswa::with([
            'siswa'=>function($q){
                return $q->select('id','nama');
            },
        ])
        ->where([
            'mapel_id'=> $data['mapel_choices']->id ?? 0,
        ]);

        if(!empty($kelas)){
            $data['list_data'] = $data['list_data']->where('kelas_id',$kelas->id);
        }
        
        $data['list_data'] = $data['list_data']->first();

        $tp_mapel = "[]";
        if( !empty($data['list_data']) && !empty($data['list_data']->first())){
            $tp_mapel = $data['list_data']->first()->lm_mapel;
        }
        try{
            $data['lm'] = json_decode($tp_mapel,true);
            if(empty($data['lm'])) $data['lm'] = [];
        }catch(Exception $e){
            $data['lm'] = [];
        }

        return view('sekolah_sd.rekap_sumatif_walikelas',$data);
    }

    function raking_kelas_index(Request $request){
        $user = $request->user();
        $data['kelas_perwalian'] = [];
        $data['selected'] = null;
        if($user->checkGuruWalikelas()){
            $data['kelas_perwalian'] = Kelas::where('wali_kelas_id',$user->id)
            ->get()
            ->pluck('id')
            ->toArray();
            arsort($data['kelas_perwalian']);
            $data['kelas_perwalian'] = array_values($data['kelas_perwalian']);
            $data['selected'] = Kelas::where('wali_kelas_id',$user->id)->first();
        }

        $data['kelas'] = null;
        if($request->kelas_id){
            $data['kelas'] = Kelas::find($request->kelas_id);
            if(empty($data['kelas'])){
                return redirect()
                ->back()
                ->with(['success'=>false,'Silahkan pilih kelas yang ada']);
            }
            $data['mapel'] = NilaiSiswa::where('kelas_id',$data['kelas']->id)
            ->join('mapels', 'mapels.id', '=', 'nilai_siswas.mapel_id')
            ->whereNull('mapels.deleted_at')
            ->groupBy('mapel_id')
            ->orderBy('mapels.orders','asc')
            ->get();
            // $data['nilai_siswa'] = NilaiSiswa::where('kelas_id',$data['kelas']->id)
            $nilai_siswa = NilaiSiswa::where('kelas_id',$data['kelas']->id)
            ->join('mapels', 'mapels.id', '=', 'nilai_siswas.mapel_id')
            ->whereNull('mapels.deleted_at')
            ->get()
            ->groupBy('siswa_id');

            Log::info('kelas_ranking >> '. json_encode($data['kelas']));
            Log::info('nilais_siswa >> '. json_encode($nilai_siswa));

            $data['nilai_siswa'] = [];

            foreach ($nilai_siswa as $key => $item) {
                $avg = $item->avg('nilai_rapor');
                $avg = number_format($avg,2);
                $total = $item->sum('nilai_rapor');
                $listItem = $item->sortBy('orders');

                $nis = $item[0]->siswa->detail['nis'] ?? '';
                $nama = $item[0]->siswa->nama ?? '';

                $list_data = [
                    'nis'=>$nis,
                    'nama'=>$nama,
                    'total'=>$total,
                    'avg'=>$avg,
                    'list_nilai'=>[],
                ];
                foreach ($listItem as $val) {
                    $ket = "";
                    if(
                        $val->nilai_rapor >= 0 &&
                        $val->nilai_rapor <= 74
                    ){
                        $ket = " (PB)";
                    }
                    if(
                        $val->nilai_rapor >= 75 &&
                        $val->nilai_rapor <= 100
                    ){
                        $ket = " (MP)";
                    }
                    $list_data['list_nilai'][] = [
                        "nilai_rapor"=>$val->nilai_rapor,
                        "ket"=>$ket
                    ];
                }
                $data['nilai_siswa'][] = $list_data;
            }

            $data['nilai_siswa'] = collect($data['nilai_siswa'])->sortByDesc('avg');
        }
        return view('sekolah_sd.ranking_kelas',$data);
    }

    function ppdb(Request $request){

        // Ambil pengaturan pertama (biasanya cuma ada 1)
        $setting = PPDBSetting::orderBy('id','desc')->where('close_ppdb',0)->first();

        // Jika belum ada di database, isi default
        if (!$setting) {
            $setting = new PPDBSetting([
                'close_ppdb' => true,
                'tgl_penerimaan' => '2026-01-01',
                'min_bulan' => 6,
                'min_tahun' => 5,
                'tahun_ajaran' => '2025/2026',
                'jumlah_tagihan' => 350000,
                'nama_bank' => 'Bank Kalbar',
                'no_rek' => '00000',
                'atas_nama' => 'SD Muhammadiyah 2',
            ]);
        }

        // Kirim data ke view (dengan key yang sama seperti sebelumnya)
        $data = [
            'close_ppdb' => $setting->close_ppdb,
            'tgl_penerimaan' => $setting->tgl_penerimaan,
            'min_bulan' => $setting->min_bulan,
            'min_tahun' => $setting->min_tahun,
            'tahun_ajaran' => $setting->tahun_ajaran,
            'jumlah_tagihan' => $setting->jumlah_tagihan,
            'nama_bank' => $setting->nama_bank,
            'no_rek' => $setting->no_rek,
            'atas_nama' => $setting->atas_nama,
        ];

        $today = Carbon::today();
        $data['statistik']['hari_ini'] = Visitor::whereDate('created_at', $today)->count();
        $data['statistik']['bulan_ini'] = Visitor::whereMonth('created_at', $today->month)->count();
        $data['statistik']['total'] = Visitor::count();

        return view('compro.koneksiedu.ppdb', $data);
    }

    public function validasiBayar($id)
    {
        $data = PPDBSekolah::find($id);
        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }

        if ($data->status_bayar === 'sudah') {
            return response()->json([
                'status' => false,
                'message' => 'Pembayaran sudah divalidasi sebelumnya.'
            ]);
        }

        $data->update([
            'status_bayar' => 'sudah',
            'validated_by' => auth()->id(),
            'validated_at' => now(),
            'keterangan' => 'Pembayaran divalidasi oleh ' . (auth()->user()->name ?? 'Admin') . ' pada ' . now()->translatedFormat('d F Y H:i'),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Pembayaran berhasil divalidasi.'
        ]);
    }


    function peserta_didik_baru(Request $request){
        $data['ppdb_setting'] = PPDBSetting::where('close_ppdb',0)->latest()->first();
        $startDate = Carbon::now()->subDays(30);
        $endDate = Carbon::now();

        // 🔹 Hitung kunjungan ke halaman PPDB (selama 30 hari)
        $data['visitorCount'] = Visitor::where('page', 'ppdb-simuda')
            ->whereBetween('visited_date', [$startDate, $endDate])
            ->count();

        // 🔹 Hitung jumlah pendaftar baru (30 hari terakhir)
        $data['pendaftarCount'] = PPDBSekolah::whereBetween('created_at', [$startDate, $endDate])->count();

        return view('sekolah_sd.peserta_didik_baru',$data);
    }
    function peserta_didik_baru_config(Request $request){
        $data['ppdb_setting'] = PPDBSetting::where('close_ppdb',0)->latest()->first();
        return view('sekolah_sd.peserta_didik_baru_config',$data);
    }

    function kwitansi_ppdb(Request $request){

        $data['ppdb'] = PPDBSekolah::where('kode_bayar',$request->kode_bayar ?? '')->firstorfail();

        // Ambil pengaturan pertama (biasanya cuma ada 1)
        $setting = PPDBSetting::orderBy('id','desc')->where('close_ppdb',0)->first();

        // Jika belum ada di database, isi default
        if (!$setting) {
            $setting = new PPDBSetting([
                'close_ppdb' => false,
                'tgl_penerimaan' => '2026-01-01',
                'min_bulan' => 6,
                'min_tahun' => 5,
                'tahun_ajaran' => '2025/2026',
                'jumlah_tagihan' => 350000,
                'nama_bank' => 'Bank Kalbar',
                'no_rek' => '00000',
                'atas_nama' => 'SD Muhammadiyah 2',
            ]);
        }

        $data['jumlah_tagihan'] = $setting->jumlah_tagihan;
        $data['nama_bank'] = $setting->nama_bank;
        $data['no_rek'] = $setting->no_rek;
        $data['atas_nama'] = $setting->atas_nama;

        return view('compro.koneksiedu.kwitansi_ppdb',$data);
    }

    function cetak_kartutes_ppdb(Request $request){

        // Data peserta berdasarkan kode bayar
        $ppdb = PPDBSekolah::where('kode_bayar', $request->kode_bayar ?? '')->firstOrFail();

        // PPDB setting aktif
        $setting = PPDBSetting::where('close_ppdb', 0)->orderBy('id','desc')->first();

        // Ambil jadwal tes peserta (IQ & Pemetaan)
        $schedule = PpdbTestSchedule::where('kode_bayar', $ppdb->kode_bayar)->first();

        return view('compro.koneksiedu.cetak_kartu_ppdb', [
            'ppdb'     => $ppdb,
            'setting'  => $setting,
            'schedule' => $schedule
        ]);
    }

    function ppdb_store(Request $request){
        try{

            if($request->update_bukti && $request->kode_bayar){
                
                $data = PPDBSekolah::where('kode_bayar',$request->kode_bayar)->firstorfail();
                $data->bukti_pembayaran = $request->bukti_pembayaran ?? null;
                $data->status_bayar = 'upload';
                $data->save();

                 // 🔹 Kirim email ke semua STAFF TU
                $business_id = 13;
                $staffTU = User::role("Staff TU#$business_id")->pluck('email')->toArray();

                if (!empty($staffTU)) {
                    Mail::to($staffTU)->send(new \App\Mail\AdminUploadBuktiNotification($data));
                }
                
                return [
                    'status'=>true,
                    'message'=>"OK",
                    "data"=>$data
                ];
            }

            $input = $request->all();
            $nama = $request->nama ?? "";
            if($request->nama_lengkap){
                $nama = $request->nama_lengkap;
            }

            $setting = PPDBSetting::orderBy('id','desc')->where('close_ppdb',0)->first();

            // Tentukan biaya dasar pendaftaran
            $biayaDasar = $setting->jumlah_tagihan ?? 350000;

            // Generate 3 angka unik (antara 001 - 999)
            $kodeUnik = random_int(1, 999);
            $kodeUnikStr = str_pad($kodeUnik, 3, '0', STR_PAD_LEFT);

            // Total yang harus dibayar
            $totalBayar = $biayaDasar + $kodeUnik;

            $input['total_bayar'] = $totalBayar;
            $input['kode_unik'] = $kodeUnik;
            $input['kode_unik'] = $kodeUnik;

            $qry = [
                'nama'=>$nama,
                'kode_bayar' => 'PPDB-' . strtoupper(Str::random(2)) . $kodeUnikStr,
                'status_bayar' => 'belum',
                'biaya_dasar' => $biayaDasar,
                'total_bayar' => $totalBayar,
                'kode_unik' => $kodeUnik,
                'bank_pembayaran' =>$input['bank_pembayaran']
            ];
            

            $in = $qry;
            $in['detail'] = $input;
            $data = PPDBSekolah::create($in);


            // send to orang tua pendaftar email
            if(isset($input['email'])){
                Mail::to($input['email'])->send(new \App\Mail\NewPPDBNotification($data));
            }

            // // send to admin sekolah
            // Mail::to("itkonsultanindonesia@gmail.com")->send(new \App\Mail\AdminNewPPDBNotification($data));

            return [
                "status" => true,
                "message" =>"Data berhasil disimpan terimakasih...",
                "data" => $qry
            ];

        } catch (\Throwable $th) {
            return [
                "status"=>false,
                "message"=>$th->getMessage(),
            ];
        }
    }

    function upload(Request $request){
        try {

            // Validasi file upload
            $validated = $request->validate([
                // 'file_data' => 'required|image|max:512', // ukuran dalam kilobyte (500KB)
                'file_data' => 'required|mimes:jpeg,jpg,png|max:600', // 600 KB aman
            ]);

            if (!$request->hasFile('file_data') || !$request->file('file_data')->isValid()) {
                return [
                    "status"=>false,
                    'message' => "Format data hanya boleh image, dan maksimal ukuran 600KB"
                ];
            }

            $pathFile = $request->file_data->store('file_ppdb');
            $pathFile = url('uploads/'.$pathFile);

            return [
                "status"=>true,
                "data"=> $pathFile,
            ];
        } catch (\Throwable $th) {
            //throw $th;
            return [
                "status"=>false,
                "message"=>$th->getMessage(),
            ];
        }
    }

    function ppdb_data(Request $request){
        $query = PPDBSekolah::orderBy('id','desc');
        if($request->status_bayar){
            $query = $query->where('status_bayar',$request->status_bayar);
        }
        return DataTables::of($query)
            ->addColumn('detail', fn($row) => $row->detail ?? [])
            ->make(true);
    }
    
    function ppdb_data_show($id){
        $data = PPDBSekolah::find($id);
        if(empty($data)){
            $data = PPDBSekolah::where('kode_bayar',$id)->first();
        }
        
        if(empty($data)){
            return [
                'status'=>false,
                'message'=>'Data not found'
            ];    
        }
        return [
            'status'=>true,
            'message'=>'OK',
            'data'=>$data
        ];
    }

    function update_nama_ppdb(Request $request){
        $list = PPDBSekolah::get();
        foreach ($list as $key => $value) {
            if(isset($value->detail['nama_lengkap'])){
                $value->nama = $value->detail['nama_lengkap'];
                $value->save();
            }
        }
        return [
            'status'=>true,
            'message'=>'OK'
        ];
    }

    function ppdb_data_store(Request $request,$id){
        $data = PPDBSekolah::find($id);
        $input = $request->all();
        if($request->has('delete')){
            $data->delete();
            return [
                'status'=>true,
                'message'=>'OK'
            ];
        }
        if($request->has('update')){

            $nama = $request->nama ?? "";
            if($request->nama_lengkap){
                $nama = $request->nama_lengkap;
            }

            $data->update([
                'nama'=>$nama,
                'detail'=>$input
            ]);

            return [
                'status'=>true,
                'message'=>'OK'
            ];
        }

        // 🔸 Validasi pembayaran (Sesuai)
        if ($request->has('validasi')) {
            $data->status_bayar = 'sudah';
            $data->validated_by = auth()->id();
            $data->validated_at = now();
            $data->keterangan = null;
            $data->save();

            $this->generateScheduleFor($data->kode_bayar);

            // 🔔 Kirim email ke pendaftar
            try {
                $emailTujuan = $data->detail['email'] ?? null;
                if ($emailTujuan) {
                    Mail::to($emailTujuan)->send(new \App\Mail\PPDBPaymentValidated($data));
                }
            } catch (\Exception $e) {
                \Log::error("Gagal kirim email validasi PPDB: " . $e->getMessage());
            }

            return ['status' => true, 'message' => 'Pembayaran divalidasi'];
        }

        // 🔸 Tanggapan jika Tidak Sesuai
        if ($request->has('tanggapan')) {
            $alasan = trim($request->input('alasan', ''));
            if ($alasan == '') {
                return ['status' => false, 'message' => 'Alasan wajib diisi'];
            }

            $data->status_bayar = 'tidak sesuai';
            $data->keterangan = $alasan;
            $data->validated_by = auth()->id();
            $data->validated_at = now();
            $data->save();

            return ['status' => true, 'message' => 'Tanggapan berhasil disimpan'];
        }

        return ['status'=>false];
    }

    function export_ppdb(Request $request){
        return Excel::download(new PPDBExport, 'ppdbExport.xlsx');
    }
    function export_cetak(Request $request){
        $data['list'] = PPDBSekolah::orderBy('id','desc')->get();
        $first = $data['list']->first();
        $data['kolom'] = array_keys($first->detail);
        return view('sekolah_sd.prints.list_ppdb',$data);
    }

    function checkNikPPDB(Request $request){
        $nik = $request->nik ?? null;
        $check = PPDBSekolah::whereRaw("JSON_EXTRACT(detail, '$.nik') = '$nik'")->first();
        if(empty($check)) return ['status'=>false,'message'=>'Not registered before'];
        return ['status'=>true,'data'=>$check];
    }

    function ppdb_print(Request $request,$id){
        $data['data'] = PPDBSekolah::findorfail($id);
        // return view('sekolah_sd.prints.cetak_ppdb',$data);
        return view('compro.koneksiedu.cetak_detail_ppdb',$data);
    }

    function simudaPrivacy(Request $request){
        return view('compro.koneksiedu.privacy-policy-simuda');
    }
    function register_form(Request $request){
        return view('compro.koneksiedu.register-simuda');
    }

    function register(Request $request){
        
        try{
            $user = User::where('username',$request->nisn)->first();
            if(empty($user))
            return ['status'=>false,'message'=>'Data user tidak ditemukan'];
            $user->email = $request->email;
            $user->save();
    
            $response = Password::sendResetLink(['email'=>$user->email]);
    
            if($response == Password::RESET_LINK_SENT){
                return [
                    'status'=>true,
                    'message'=>'Link pengaturan password telah dikirim ke email anda, tolong cek inbox/spam...'
                ];
            }
    
            return ['status'=>false,'message'=>'Gagal mengirim link pengaturan password, tolong hubungi admin...'];
        } catch(\Exception $e){
            return ['status'=>false,'message'=>$e->getMessage()];
        }

    }

    function test_email() {
        // Cek apakah ada 1 data PPDB untuk contoh
        $ppdb = \App\Models\Sekolah\PPDBSekolah::latest()->first();

        if (!$ppdb) {
            return '❌ Belum ada data PPDB di database. Isi dulu minimal 1 data pendaftar.';
        }

        try {
             // 🔹 Kirim email ke semua STAFF TU
            $business_id = 13;
            $staffTU = User::role("Staff TU#$business_id")->pluck('email')->toArray();

            if (!empty($staffTU)) {
                Mail::to($staffTU)->send(new \App\Mail\NewPPDBNotification($ppdb));
            }
            return '✅ Test email PPDB berhasil dikirim ke ' . $emailTujuan;
        } catch (Exception $e) {
            return '❌ Gagal kirim email: ' . $e->getMessage();
        }
    }

    private function generateScheduleFor($kodeBayar)
    {
        // Jika sudah punya jadwal → langsung return
        $existing = PpdbTestSchedule::where('kode_bayar', $kodeBayar)->first();
        if ($existing) return $existing;

        // Ambil periode aktif
        $setting = PPDBSetting::where('close_ppdb', 0)->first();
        if (!$setting || !$setting->session_capacities) return null;

        $sessions = $setting->session_capacities;

        // Pisahkan slot IQ dan MAP
        $iqSlots  = array_filter($sessions, fn($s) => $s['type'] === 'iq');
        $mapSlots = array_filter($sessions, fn($s) => $s['type'] === 'map');

        // ===============================
        // 1. Cari slot IQ yang masih ada kuota
        // ===============================
        $selectedIQ = null;

        foreach ($iqSlots as $slot) {

            // Hitung jumlah peserta yang sudah terisi di slot ini
            $filled = PpdbTestSchedule::where('iq_date', $slot['date'])
                        ->where('iq_start_time', $slot['start'])
                        ->count();

            if ($filled < $slot['capacity']) {
                $selectedIQ = $slot;
                break;
            }
        }

        // Jika tidak ada slot IQ kosong → tidak bisa assign
        if (!$selectedIQ) return null;

        // ===============================
        // 2. Cari slot MAP yang masih ada kuota
        // ===============================
        $selectedMAP = null;

        foreach ($mapSlots as $slot) {

            $filled = PpdbTestSchedule::where('map_date', $slot['date'])
                        ->where('map_start_time', $slot['start'])
                        ->count();

            if ($filled < $slot['capacity']) {
                $selectedMAP = $slot;
                break;
            }
        }

        // Kalau tidak ada slot MAP → jadwal IQ tetap masuk, MAP kosong
        // (opsional: bisa dibuat wajib MAP, tapi saya ikuti logika default)
        if (!$selectedMAP) {
            $selectedMAP = [
                "date" => null,
                "start" => null,
                "end" => null
            ];
        }

        // ===============================
        // 3. SIMPAN JADWAL
        // ===============================
        return PpdbTestSchedule::create([
            'kode_bayar' => $kodeBayar,

            'iq_date'       => $selectedIQ['date'],
            'iq_start_time' => $selectedIQ['start'],
            'iq_end_time'   => $selectedIQ['end'],

            'map_date'       => $selectedMAP['date'],
            'map_start_time' => $selectedMAP['start'],
            'map_end_time'   => $selectedMAP['end'],
        ]);
    }

    // private function generateScheduleFor($kodeBayar)
    // {
    //     // Cek apakah jadwal sudah ada
    //     $existing = PpdbTestSchedule::where('kode_bayar', $kodeBayar)->first();
    //     if ($existing) return $existing;

    //     // Ambil setting PPDB aktif
    //     $setting = PPDBSetting::where('close_ppdb', 0)->first();
    //     if (!$setting) return null; // tidak ada periode aktif = skip

    //     // Aturan dinamis
    //     $iqDays  = $setting->iq_days ?? [];
    //     $mapDays = $setting->map_days ?? [];
    //     $sessions = $setting->sessions ?? [];
    //     $perSesi = $setting->capacity_per_session ?? 14;

    //     $slotPerHari = count($sessions);
    //     $hariJumlah  = count($iqDays);
    //     $perHari     = $perSesi * $slotPerHari;

    //     // Ambil semua peserta yang sudah divalidasi
    //     $validated = PPDBSekolah::where('status_bayar', 'sudah')
    //                 ->orderBy('validated_at')
    //                 ->pluck('kode_bayar')
    //                 ->toArray();

    //     $index = array_search($kodeBayar, $validated);
    //     if ($index === false) return null;

    //     // Hitung hari
    //     $hariKe = floor($index / $perHari);
    //     if ($hariKe >= $hariJumlah) $hariKe = $hariJumlah - 1;

    //     // Hitung sesi
    //     $sisa = $index % $perHari;
    //     $sesiKe = floor($sisa / $perSesi);

    //     // Ambil tanggal & jam berdasarkan index
    //     $iqDate = $iqDays[$hariKe] ?? null;
    //     $mapDate = $mapDays[$hariKe] ?? null;

    //     [$iqStart, $iqEnd] = $sessions[$sesiKe] ?? [null, null];
    //     [$mapStart, $mapEnd] = $sessions[$sesiKe] ?? [null, null];

    //     // Simpan jadwal
    //     return PpdbTestSchedule::create([
    //         'kode_bayar' => $kodeBayar,

    //         'iq_date' => $iqDate,
    //         'iq_start_time' => $iqStart,
    //         'iq_end_time' => $iqEnd,

    //         'map_date' => $mapDate,
    //         'map_start_time' => $mapStart,
    //         'map_end_time' => $mapEnd,
    //     ]);
    // }
    
}