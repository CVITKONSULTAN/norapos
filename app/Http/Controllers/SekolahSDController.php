<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \App\Models\Sekolah\Kelas;
use \App\Models\Sekolah\Siswa;
use \App\Models\Sekolah\NilaiSiswa;
use \App\Models\Sekolah\Mapel;
use \App\Models\Sekolah\KelasSiswa;
use \App\Models\Sekolah\Ekstrakurikuler;
use \App\Models\Sekolah\EkskulSiswa;

use Spatie\Permission\Models\Role;

class SekolahSDController extends Controller
{
    function dashboard(Request $request){
        return view('sekolah_sd.dashboard');
    }
    function kelas_index(Request $request){
        return view('sekolah_sd.ruang_kelas');
    }
    function jurnal_kelas(Request $request){
        $user = $request->user();
        if($user->checkGuru()){
            $list = $user->tendik->mapel_list();
            $mapel = Mapel::whereIn('id',$list)->get();
            $data['mapel'] = Mapel::whereIn('id',$list)
            ->groupBy('nama')
            ->get();
            $data['list_kelas'] = $mapel->groupBy('kelas')->keys();
            $data['kelas'] = Kelas::whereIn('kelas',$data['list_kelas'])
            ->orderBy('id','desc')
            ->get();
            
        } else {
            $mapel = Mapel::all();
            $data['mapel'] = Mapel::groupBy('nama')->get();
            $data['list_kelas'] = [1,2,3,4,5,6];
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
        
        $data['mapel_id_list'] = [];
        
        if($request->user()->checkGuru()){
            try {
                $data['mapel_id_list'] = json_decode($request->user()->tendik->mapel_id_list,true);
                if(empty($data['mapel_id_list']))
                $data['mapel_id_list'] = [];
            } catch (\Throwable $th) {
                $data['mapel_id_list'] = [];
            }
        }
        return view('sekolah_sd.mapel',$data);
    }
    function data_mapel_create(Request $request){
        return view('sekolah_sd.input.mapel.create');
    }
    
    function data_rekap_nilai_index(Request $request){
        
        $filter = $request->all();

        $data['filter'] = $filter;

        $data['tahun_ajaran'] = Kelas::getGroupBy('tahun_ajaran');
        $data['semester'] = Kelas::getGroupBy('semester');
        $data['nama_kelas'] = Kelas::getGroupBy('nama_kelas');
        $data['mapel'] = Mapel::all();

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

        $data['mapel_choices'] = $data['mapel']->first();
        if(isset($filter['mapel_id'])){
            $data['mapel_choices'] = $data['mapel']->where('id',$filter['mapel_id'])->first();
        }

        $data['list_data'] = NilaiSiswa::with([
            'siswa'=>function($q){
                return $q->select('id','nama');
            },
        ])
        ->where([
            'mapel_id'=> $data['mapel_choices']->id
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

        $data['list_data'] = $data['list_data']->get();

        // if(empty($data['list_data']->first()))
        // return redirect()->route('sekolah_sd.kelas.index')
        // ->with(['success'=>false,'Silahkan lengkapi data kelas & mapel terlebih dahulu']);

        $tp_mapel = "[]";
        if( !empty($data['list_data']) && !empty($data['list_data']->first())){
            $tp_mapel = $data['list_data']->first()->tp_mapel;
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

        $data['tahun_ajaran'] = Kelas::getGroupBy('tahun_ajaran');
        $data['semester'] = Kelas::getGroupBy('semester');
        $data['nama_kelas'] = Kelas::getGroupBy('nama_kelas');
        $data['mapel'] = Mapel::all();

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

        $data['mapel_choices'] = $data['mapel']->first();
        if(isset($filter['mapel_id'])){
            $data['mapel_choices'] = $data['mapel']->where('id',$filter['mapel_id'])->first();
        }

        $data['list_data'] = NilaiSiswa::with([
            'siswa'=>function($q){
                return $q->select('id','nama');
            },
        ])
        ->where([
            'mapel_id'=> $data['mapel_choices']->id
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

        $data['list_data'] = $data['list_data']->get();


        // if(empty($data['list_data']->first()))
        // return redirect()->route('sekolah_sd.kelas.index')
        // ->with(['success'=>false,'Silahkan lengkapi data kelas & mapel terlebih dahulu']);

        // // $data['lm'] = json_decode($data['list_data']->first()->lm_mapel,true);
        // try{
        //     $data['lm'] = json_decode($data['list_data']->first()->lm_mapel,true);
        //     if(empty($data['lm'])) $data['lm'] = [];
        // }catch(Exception $e){
        //     $data['lm'] = [];
        // }

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
        if($user->checkGuru()){
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
        return view('sekolah_sd.project');
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
        $data['alamat'] = $data['location']->getLocationAddressAttribute();
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
        $data['alamat'] = $data['location']->getLocationAddressAttribute();
        // dd($data);

        $data['tahun_ajaran'] = Kelas::getGroupBy('tahun_ajaran');
        $data['semester'] = Kelas::getGroupBy('semester');
        $data['nama_kelas'] = Kelas::getGroupBy('nama_kelas');

        $kelas = Kelas::first();
        $siswa = Siswa::first();

        $data['ekskul'] = Ekstrakurikuler::orderBy('id','desc')->get();

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

        
        if($request->has('kelas_id')){
            $data['kelas_siswa'] = KelasSiswa::find($request->kelas_id);
        }
        // dd($data['kelas_siswa']);

        $data['nilai_list'] = NilaiSiswa::where([
            'kelas_id'=> $data['kelas_siswa']->kelas_id,
            'siswa_id'=> $data['kelas_siswa']->siswa_id,
        ])
        ->with('mapel')
        ->get();
        // dd($data['nilai_list']);

        return view('sekolah_sd.raport_akhir',$data);
    }

    function raport_akhir_print(Request $request, Int $id){
        
        $data['kelas_siswa'] = KelasSiswa::findorfail($id);

        $data['business'] = $request->user()->business;
        $data['location'] = $data['business']->locations[0];
        $data['alamat'] = $data['location']->getLocationAddressAttribute();

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

        return view('sekolah_sd.prints.akhir',$data);
    }

    function raport_tengah_print(Request $request, Int $id){
        
        $data['kelas_siswa'] = KelasSiswa::findorfail($id);

        $data['business'] = $request->user()->business;
        $data['location'] = $data['business']->locations[0];
        $data['alamat'] = $data['location']->getLocationAddressAttribute();

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
            $roleList = ['guru','admin','kepala sekolah'];
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
}
