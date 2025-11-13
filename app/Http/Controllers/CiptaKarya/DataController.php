<?php

namespace App\Http\Controllers\CiptaKarya;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CiptaKarya\PengajuanPBG;
use App\Models\CiptaKarya\PetugasLapangan;
use Validator;
use DataTables;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;

class DataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list_index()
    {
        return view('ciptakarya.list_pbg');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function petugas_index()
    {
        return view('ciptakarya.petugas');
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
    public function store_pbg(Request $request)
    {
        // ========== DELETE ==========
        if ($request->delete == 1) {
            if (!$request->id) {
                return response()->json(['status' => false, 'message' => 'ID tidak ditemukan']);
            }

            $data = PengajuanPBG::find($request->id);
            if (!$data) {
                return response()->json(['status' => false, 'message' => 'Data tidak ditemukan']);
            }

            $data->delete();
            return response()->json(['status' => true, 'message' => 'Data berhasil dihapus']);
        }

        // ========== INSERT ==========
        if ($request->insert == 1) {

            // Validasi simple
            $validator = Validator::make($request->all(), [
                'no_permohonan' => 'required|unique:pengajuan,no_permohonan',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
            }

            $data = PengajuanPBG::create($request->except(['_token', 'insert', 'update', 'delete']));
            return response()->json(['status' => true, 'message' => 'Data berhasil ditambahkan', 'data' => $data]);
        }

        // ========== UPDATE ==========
        if ($request->update == 1) {
            if (!$request->id) {
                return response()->json(['status' => false, 'message' => 'ID wajib dikirim untuk update']);
            }

            $data = PengajuanPBG::find($request->id);
            if (!$data) {
                return response()->json(['status' => false, 'message' => 'Data tidak ditemukan']);
            }

            // Validasi unik kecuali data sendiri
            $validator = Validator::make($request->all(), [
                'no_permohonan' => 'required|unique:pengajuan,no_permohonan,' . $request->id,
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
            }

            $data->update($request->except(['_token', 'insert', 'update', 'delete']));
            return response()->json(['status' => true, 'message' => 'Data berhasil diperbarui', 'data' => $data]);
        }

        return response()->json(['status' => false, 'message' => 'Tidak ada aksi yang dipilih']);

    }

    /**
     * Display the specified resource PBG
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show_pbg($id)
    {
         $data = PengajuanPBG::find($id);
        return $data ?
            response()->json(['status' => true, 'data' => $data]) :
            response()->json(['status' => false]);
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
     * List Datatables PBG
     *
     * @return \Illuminate\Http\Response
     */
    public function list_data_pbg(Request $request)
    {
        // return DataTables::of(PengajuanPBG::orderBy('id','desc'))->make(true);
        $query = PengajuanPBG::query()->orderBy('id', 'desc');

        // ✅ Filter Tahun (created_at)
        if ($request->has('tahun') && $request->tahun != '') {
            $query->whereYear('created_at', $request->tahun);
        }

        // ✅ Filter Kategori Permohonan (misal: fungsi_bangunan / tipe)
        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('fungsi_bangunan', $request->kategori);
        }

        // ✅ Filter Jenis Izin (field: tipe — PBG / SLF)
        if ($request->has('jenis') && $request->jenis != '') {
            $query->where('tipe', $request->jenis);
        }

        // ✅ Filter Status (pending / approved / rejected)
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        return DataTables::of($query)->make(true);
    }

    /**
     * List Datatables Petugas
     *
     * @return \Illuminate\Http\Response
     */
    public function list_data_petugas()
    {
        return DataTables::of(PetugasLapangan::orderBy('id','desc'))->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_petugas_lapangan(Request $request)
    {
        // ========== DELETE ==========
        if ($request->delete == 1) {
            if (!$request->id) {
                return response()->json(['status' => false, 'message' => 'ID tidak ditemukan']);
            }

            $data = PetugasLapangan::find($request->id);
            if (!$data) {
                return response()->json(['status' => false, 'message' => 'Data tidak ditemukan']);
            }

            $data->delete();
            return response()->json(['status' => true, 'message' => 'Data berhasil dihapus']);
        }

        // ========== INSERT ==========
        if ($request->insert == 1) {

            // Validasi simple
            $validator = Validator::make($request->all(), [
                'email' => 'required|unique:petugas_lapangans,email',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
            }

            $data = PetugasLapangan::create($request->except(['_token', 'insert', 'update', 'delete']));
            return response()->json(['status' => true, 'message' => 'Data berhasil ditambahkan', 'data' => $data]);
        }

        // ========== UPDATE ==========
        if ($request->update == 1) {
            if (!$request->id) {
                return response()->json(['status' => false, 'message' => 'ID wajib dikirim untuk update']);
            }

            $data = PetugasLapangan::find($request->id);
            if (!$data) {
                return response()->json(['status' => false, 'message' => 'Data tidak ditemukan']);
            }

            // Validasi unik kecuali data sendiri
            $validator = Validator::make($request->all(), [
                'email' => 'required|unique:petugas_lapangans,email,' . $request->id,
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
            }

            $data->update($request->except(['_token', 'insert', 'update', 'delete']));
            return response()->json(['status' => true, 'message' => 'Data berhasil diperbarui', 'data' => $data]);
        }

        return response()->json(['status' => false, 'message' => 'Tidak ada aksi yang dipilih']);

    }

    public function dashboard() {
        $totalTerbit = PengajuanPBG::where('status', 'approved')->count();
        $totalPengajuan = PengajuanPBG::count();
        $totalRetribusi = PengajuanPBG::sum('nilai_retribusi'); // kalau ada field ini

        // Grafik 5 tahun terakhir
        $years = range(now()->year - 4, now()->year);
        $grafikTerbit = [];
        $grafikPengajuan = [];

        foreach ($years as $year) {
            $grafikTerbit[] = PengajuanPBG::whereYear('created_at', $year)->where('status', 'approved')->count();
            $grafikPengajuan[] = PengajuanPBG::whereYear('created_at', $year)->count();
        }

        // Jenis izin (Donut)
        $jenisIzin = PengajuanPBG::select('fungsi_bangunan', DB::raw('count(*) as total'))
            ->groupBy('fungsi_bangunan')
            ->get();

        // Wilayah terbanyak (Bar chart)
        $wilayah = PengajuanPBG::select('lokasi_bangunan', DB::raw('count(*) as total'))
            ->groupBy('lokasi_bangunan')
            ->orderByDesc('total')
            ->take(9)
            ->get();

        return response()->json([
            'status' => true,
            'data' => [
                'total_terbit' => $totalTerbit,
                'total_pengajuan' => $totalPengajuan,
                'total_retribusi' => $totalRetribusi,
                'grafik_trend' => [
                    'tahun' => $years,
                    'terbit' => $grafikTerbit,
                    'pengajuan' => $grafikPengajuan,
                ],
                'jenis_izin' => $jenisIzin,
                'wilayah' => $wilayah,
            ]
        ]);
    }

    public function login_mobile(Request $request) {

        
        if($request->email !== "demo@kuburaya.go.id"){
            $petugas = PetugasLapangan::where('email',$request->email)->first();
        } else {
            $petugas = PetugasLapangan::first();
        }

        if(!$petugas)
        return response()
        ->json(
            ['status' => false, 'message' => 'Email anda belum terdaftar pada data admin']
        ,400);

        if(!empty($petugas->deleted_at))
            return response()
            ->json(
                ['status' => false, 'message' => 'Akun telah di hapus...']
            ,400);

        $auth_token = Str::random(16);
        
        $petugas->google_data = $request->google_data;
        $petugas->auth_token = $auth_token;

        $token = [
                    "auth_token" => $auth_token,
                    "created_at" => date('Y-m-d H:i:s')
        ];

        $petugas->save();
        return response()
            ->json(['status' => true, 'message' => 'OK','data'=>[
                'token'=> Crypt::encrypt( json_encode($token) )
            ]]);
    }

    public function update_petugas(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:pengajuan,id',
            'petugas_id' => 'required|exists:petugas_lapangans,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        }

        $pengajuan = PengajuanPBG::find($request->id);
        $petugas = PetugasLapangan::find($request->petugas_id);

        $pengajuan->petugas_id = $petugas->id;
        $pengajuan->petugas_lapangan = $petugas->toArray(); // simpan juga nama/email

        $pengajuan->save();

        return response()->json(['status' => true, 'message' => 'Petugas berhasil dikaitkan']);
    }

    public function search_petugas(Request $request)
    {
        $term = $request->q ?? '';

        $query = PetugasLapangan::query()
            ->select('id', 'nama', 'email')
            ->when($term, function ($q) use ($term) {
                $q->where('nama', 'like', "%{$term}%")
                ->orWhere('email', 'like', "%{$term}%");
            })
            ->limit(20)
            ->get();

        $results = $query->map(function ($p) {
            return [
                'id' => $p->id,
                'text' => "{$p->nama} ({$p->email})"
            ];
        });

        return response()->json(['results' => $results]);
    }

    public function statistic_mobile(Request $request)
    {
        $petugas = $request->petugas;

        $proses = PengajuanPBG::where([
            'status'=>'pending',
            'petugas_id' => $petugas->id
        ])->count();
        $terbit = PengajuanPBG::where([
            'status'=>'terbit',
            'petugas_id' => $petugas->id
        ])->count();
        $gagal = PengajuanPBG::where([
            'status'=>'gagal',
            'petugas_id' => $petugas->id
        ])->count();
        

        return response()->json([
            'status' => true,
            'message' => 'Berhasil',
            'petugas' => $petugas->nama,
            'data' => [
                'proses' => $proses,
                'izin_terbit' => $terbit,
                'gagal' => $gagal
            ]
        ]);
    }

    public function list_pengajuan(Request $request)
    {
        $petugas = $request->petugas;

        // ambil filter status (opsional)
        $status = $request->input('status');
        $perPage = $request->input('per_page', 10);
        $search = $request->input('search'); // ✅ tambahkan search opsional

        // query data berdasarkan petugas login
        $query = PengajuanPBG::where('petugas_id', $petugas->id)
            ->orderBy('created_at', 'desc');

        if ($status) {
            $query->where('status', $status);
        }

         // ✅ Filter pencarian (jika ada)
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_pemohon', 'like', "%{$search}%")
                ->orWhere('no_permohonan', 'like', "%{$search}%")
                ->orWhere('fungsi_bangunan', 'like', "%{$search}%")
                ->orWhere('nama_bangunan', 'like', "%{$search}%");
            });
        }

        $data = $query->paginate($perPage);

        return response()->json([
            'status' => true,
            'message' => 'Berhasil mengambil data pengajuan',
            'petugas' => $petugas->nama,
            'pagination' => [
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
                'per_page' => $data->perPage(),
                'total' => $data->total(),
            ],
            'data' => $data->items()
        ]);
    }

    public function show_pengajuan(Request $request,$id)
    {
        $petugas = $request->petugas;

        // query data berdasarkan petugas login
        $data = PengajuanPBG::where([
            'petugas_id'=>$petugas->id,
            'id'=>$id
        ])->first();

        if(empty($data))
            return response()->json([
                'status' => false,
                'message' => "data not found"
            ]);

        return response()->json([
            'status' => true,
            'message' => 'OK',
            'data'=>$data
        ]);
    }

    public function delete_account(Request $request)
    {
        $petugas = $request->petugas;
        $petugas->deleted_at = date('Y-m-d H:i:s');
        $petugas->save();
        return response()->json([
            'status' => true,
            'message' => 'Akun berhasil di hapus'
        ]);
    }

    public function store_question_answer(Request $request,$id)
    {
        $petugas = $request->petugas;

        // query data berdasarkan petugas login
        $data = PengajuanPBG::where([
            'petugas_id'=>$petugas->id,
            'id'=>$id
        ])->first();

        if(empty($data))
            return response()->json([
                'status' => false,
                'message' => "data not found"
            ]);

        if($request->list_foto){
            $data->list_foto = json_encode($request->list_foto);
            $data->save();
            return response()->json([
                'status' => true,
                'message' => 'Photo saved',
            ]);
        }

        $data->answers = json_encode($request->answers);
        $data->questions = json_encode($request->questions);
        $data->save();

        return response()->json([
            'status' => true,
            'message' => 'OK',
        ]);
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

            $pathFile = $request->file_data->store('file_ciptakarya');
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

    function print_data(Request $request,$id){
        return view('ciptakarya.cetak_list_pbg');
    }

    function detail_data(Request $request,$id){
        $data['pengajuan'] = PengajuanPBG::findorfail($id);
        if($data['pengajuan']) $data['pengajuan'] = $data['pengajuan']->toArray();
        return view('ciptakarya.detail_pbg',$data);
    }

    public function updateRetribusi(Request $request, $id)
    {
        $p = PengajuanPBG::find($id);

        $p->nilai_retribusi = str_replace(',', '', $request->nilai_retribusi);
        $p->save();

        return response()->json(['status' => true]);
    }    

}
