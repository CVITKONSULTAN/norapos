<?php

namespace App\Http\Controllers\CiptaKarya;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\CiptaKarya\PengajuanPBG;
use App\Models\CiptaKarya\PetugasLapangan;
use App\Models\CiptaKarya\PbgTracking;
use App\Models\CiptaKarya\Kecamatan;
use App\User;

use Validator;
use DataTables;
use DB;
use Mail;
use Log;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use App\Helpers\Helper;

use App\Mail\PetugasAssignedMail;

class DataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list_index()
    {
        $data['kecamatan'] = Kecamatan::orderBy('nama')->get();
        return view('ciptakarya.list_pbg',$data);
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

            $input = $request->except(['_token', 'insert', 'update', 'delete']);
            $input['answers'] = json_encode([]);
            $input['questions'] = json_encode([]);

            $data = PengajuanPBG::create($input);

            $role = auth()->user()->roles->first()->name ?? 'admin'; // pastikan role tersedia

            $tracking = PbgTracking::updateOrCreate(
                [
                    'pengajuan_id' => $data->id,
                    'role' => $role
                ],
                [
                    'user_id' => auth()->id(),
                    'catatan' => "Membuat data pbg",
                    'status' => "proses",
                    'verified_at' => now()
                ]
            );

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
        // $query = PengajuanPBG::query()->orderBy('id', 'desc');
        $query = PengajuanPBG::select([
            'id',
            'no_permohonan',
            'tipe',
            'nama_pemohon',
            'fungsi_bangunan',
            'nama_bangunan',
            'lokasi_bangunan',
            'nilai_retribusi',
            'status',
            'petugas_id',
            'created_at',
            'excel_retribusi',
            'tgl_penugasan',
            'kecamatan_id',
            'nama_kecamatan',
        ])
        ->with(['petugas:id,nama'])
        ->orderBy('id', 'desc');

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
        if ($request->has('kecamatan_id') && $request->kecamatan_id != '') {
            $query->where('kecamatan_id', $request->kecamatan_id);
        }

        return DataTables::of($query)
            ->addColumn('hari_kerja', function($row) {
                // Hitung hari kerja (exclude Sabtu & Minggu)
                return $this->hitungHariKerja($row->created_at, now());
            })
            ->make(true);
    }

    /**
     * Hitung hari kerja (tidak termasuk Sabtu & Minggu)
     */
    private function hitungHariKerja($startDate, $endDate)
    {
        $start = \Carbon\Carbon::parse($startDate);
        $end = \Carbon\Carbon::parse($endDate);
        
        $hariKerja = 0;
        
        while ($start->lte($end)) {
            // 6 = Sabtu, 0 = Minggu
            if ($start->dayOfWeek !== 6 && $start->dayOfWeek !== 0) {
                $hariKerja++;
            }
            $start->addDay();
        }
        
        return $hariKerja;
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

    public function dashboard()
    {
        // ======================
        // KPI
        // ======================
        $totalTerbit     = PengajuanPBG::where('status', 'terbit')
        ->whereNull('deleted_at')
        ->count();
        $totalPengajuan  = PengajuanPBG::whereNull('deleted_at')->count();
        $totalRetribusi  = PengajuanPBG::whereNull('deleted_at')->sum('nilai_retribusi');

        // ======================
        // Grafik Trend (LAMA)
        // ======================
        $years = range(now()->year - 4, now()->year);
        $grafikTerbit = [];
        $grafikPengajuan = [];

        foreach ($years as $year) {
            $grafikTerbit[] = PengajuanPBG::whereYear('created_at', $year)
                ->whereNull('deleted_at')
                ->where('status', 'terbit')->count();

            $grafikPengajuan[] = PengajuanPBG::whereYear('created_at', $year)
            ->whereNull('deleted_at')
            ->count();
        }

        // ======================
        // Donut Jenis Izin
        // ======================
        $jenisIzin = PengajuanPBG::selectRaw('
                COALESCE(fungsi_bangunan, "Tidak diketahui") as fungsi_bangunan,
                COUNT(*) as total
            ')
            ->whereNull('deleted_at')
            ->groupBy('fungsi_bangunan')
            ->get();

        // ======================
        // Bar Kecamatan (BARU)
        // ======================
        $wilayah = DB::table('kecamatans as k')
            ->leftJoin('pengajuan as p', function ($join) {
                $join->on('k.id', '=', 'p.kecamatan_id')
                ->whereNull('p.deleted_at');
            })
            ->selectRaw('
                k.id as kecamatan_id,
                k.nama as nama_kecamatan,
                COUNT(p.id) as total
            ')
            ->groupBy('k.id', 'k.nama')
            ->orderBy('k.nama')
            ->get();
        
        $unknownTotal = PengajuanPBG::whereNull('deleted_at')->whereNull('kecamatan_id')
            ->orWhere('kecamatan_id', 0)
            ->count();

        $wilayah = $wilayah->push((object) [
            'kecamatan_id' => 0,
            'nama_kecamatan' => 'Tidak diketahui',
            'total' => $unknownTotal
        ]);



        // ======================
        // BAR BARU: Status x Tipe
        // ======================
        $summary = PengajuanPBG::selectRaw('
                tipe,
                SUM(CASE WHEN status = "proses" THEN 1 ELSE 0 END) as proses,
                SUM(CASE WHEN status = "terbit" THEN 1 ELSE 0 END) as terbit,
                SUM(CASE WHEN status = "tidak" THEN 1 ELSE 0 END) as tidak
            ')
            ->whereNull('deleted_at')
            ->groupBy('tipe')
            ->get()
            ->keyBy('tipe');

        $kategori = ['PBG', 'SLF', 'PBG/SLF'];

        $dataProses = [];
        $dataTerbit = [];
        $dataTidak  = [];

        foreach ($kategori as $k) {
            $dataProses[] = $summary[$k]->proses ?? 0;
            $dataTerbit[] = $summary[$k]->terbit ?? 0;
            $dataTidak[]  = $summary[$k]->tidak ?? 0;
        }

        // ======================
        // RESPONSE FINAL
        // ======================
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

                // 🔥 BAR BARU
                'grafik_status_tipe' => [
                    'kategori' => $kategori,
                    'series' => [
                        ['name' => 'Proses', 'data' => $dataProses],
                        ['name' => 'Terbit', 'data' => $dataTerbit],
                        ['name' => 'Tolak',  'data' => $dataTidak],
                    ]
                ]
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

        $pengajuan->tgl_penugasan = date('Y-m-d H:i:s');

        $pengajuan->save();

        // Kirim email notifikasi
        if (!empty($petugas->email)) {
            Mail::to($petugas->email)->send(new PetugasAssignedMail($pengajuan, $petugas));
        }

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
        $role = "petugas#$petugas->id&$petugas->nama"; // pastikan role tersedia

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

        if($request->photoMaps){
            $data->photoMaps = json_encode($request->photoMaps);
            $tracking = PbgTracking::updateOrCreate(
                [
                    'pengajuan_id' => $data->id,
                    'role' => $role
                ],
                [
                    'user_id' => auth()->id(),
                    'catatan' => 'Menyimpan hasil pemeriksaan lapangan',
                    'status' => "proses",
                    'verified_at' => now()
                ]
            );
        }

        if($request->list_foto){
            $data->list_foto = json_encode($request->list_foto);
            // $data->save();
            // return response()->json([
            //     'status' => true,
            //     'message' => 'Photo saved',
            // ]);
        }

        if($request->answers)
        $data->answers = json_encode($request->answers);
        
        if($request->questions)
        $data->questions = json_encode($request->questions);
    
        $data->save();

        // $business_id = 15; //local
        $business_id = 18; //server
        // Cari user admin_retribusi
        $admin = User::role("Pemeriksa#$business_id")->get();

        $role = 'Petugas Lapangan#'.$business_id; // pastikan role tersedia

        $tracking = PbgTracking::updateOrCreate(
                [
                    'pengajuan_id' => $data->id,
                    'role' => $role
                ],
                [
                    'user_id' => auth()->id(),
                    'catatan' => "mengisi data pengajuan",
                    'status' => "proses",
                    'verified_at' => now()
                ]
            );

        if($admin->count() > 0){
            $emailList = $admin->pluck('email')->toArray();

            // Kirim email
            \Mail::to($emailList)->send(new \App\Mail\NotifVerifikasiRetribusi(
                $data,
                $tracking
            ));
        }

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

    function print_data(Request $request, $id)
    {
        $pengajuan = PengajuanPBG::findOrFail($id)->toArray();
        if (
            $pengajuan['status'] !== 'terbit' 
            && (
                !auth()->user()->checkRole('kepala bidang') ||
                !auth()->user()->checkRole('kepala dinas')
                )
            ) {
            abort(403, 'Dokumen belum terbit');
        }

        // Decode answers
        $answers = json_decode($pengajuan['answers'], true) ?? [];
        $sections = json_decode($pengajuan['questions'], true) ?? [];

        $results = [];

        // Helper untuk memisahkan answer & visual
        $parseAnswer = function($val) {
            if (!is_numeric($val)) {
                return [
                    'answer' => null,   // tidak dianggap Ya/Tidak
                    'visual' => $val    // ini teks visual
                ];
            }
            return [
                'answer' => Helper::answerLabel($val),
                'visual' => null
            ];
        };

        foreach ($sections as $section) {

            $sec = [
                'caption' => $section['caption'],
                'rows' => [],
                'child' => [],
            ];

            /* ======================================================
            * LEVEL 1  (section -> questioner)
            ====================================================== */
            if (isset($section['questioner'])) {

                foreach ($section['questioner'] as $i => $q) {

                    $key = $section['caption'] . '__' . $i;

                    $val = $answers[$key]['value'] ?? null;
                    $parsed = $parseAnswer($val);

                    $sec['rows'][] = [
                        'question' => $q['question'],
                        'answer'   => $parsed['answer'],
                        'visual'   => $parsed['visual'],
                    ];
                }
            }


            /* ======================================================
            * LEVEL 2  (section -> child)
            ====================================================== */
            if (isset($section['child'])) {

                foreach ($section['child'] as $child1) {

                    $sub = [
                        'caption' => $child1['caption'],
                        'rows' => [],
                        'child' => []
                    ];

                    // child1 langsung punya questioner
                    if (isset($child1['questioner'])) {

                        foreach ($child1['questioner'] as $i => $q) {

                            $key = $section['caption']
                                . ' > ' . $child1['caption']
                                . '__' . $i;

                            $val = $answers[$key]['value'] ?? null;
                            $parsed = $parseAnswer($val);

                            $sub['rows'][] = [
                                'question' => $q['question'],
                                'answer'   => $parsed['answer'],
                                'visual'   => $parsed['visual'],
                            ];
                        }
                    }


                    /* ======================================================
                    * LEVEL 3  (section -> child -> subchild)
                    ====================================================== */
                    if (isset($child1['child'])) {

                        foreach ($child1['child'] as $child2) {

                            $sub2 = [
                                'caption' => $child2['caption'],
                                'rows' => []
                            ];

                            foreach ($child2['questioner'] as $i => $q) {

                                $key = $section['caption']
                                    . ' > ' . $child1['caption']
                                    . ' > ' . $child2['caption']
                                    . '__' . $i;

                                $val = $answers[$key]['value'] ?? null;
                                $parsed = $parseAnswer($val);

                                $sub2['rows'][] = [
                                    'question' => $q['question'],
                                    'answer'   => $parsed['answer'],
                                    'visual'   => $parsed['visual'],
                                ];
                            }

                            $sub['child'][] = $sub2;
                        }
                    }

                    $sec['child'][] = $sub;
                }
            }

            $results[] = $sec;
        }


        /* ======================================================
        * FOTO MAPPING
        ====================================================== */
        $photos = json_decode($pengajuan['photoMaps'] ?? '[]', true);

        $sectionPhotos = [];

        foreach ($photos as $p) {

            preg_match('/^(\d+)-/', $p['caption'], $match);

            if (!isset($match[1])) continue;

            $sectionNum = $match[1];

            $sectionPhotos[$sectionNum][] = [
                'caption' => $p['caption'],
                'url' => $p['url']
            ];
        }

        return view('ciptakarya.cetak_list_pbg', [
            'pengajuan'        => $pengajuan,
            'inspectionResults'=> $results,
            'sectionPhotos'    => $sectionPhotos,
        ]);
    }


    // function detail_data(Request $request,$id){
    //     $data['pengajuan'] = PengajuanPBG::findorfail($id);
    //     if($data['pengajuan']) $data['pengajuan'] = $data['pengajuan']->toArray();
    //     return view('ciptakarya.detail_pbg',$data);
    // }

    public function updateRetribusi(Request $request, $id)
    {
        $p = PengajuanPBG::findOrFail($id);

        // VALIDASI
        $request->validate([
            'nilai_retribusi' => 'required',
            'excel_retribusi' => 'nullable|mimes:xls,xlsx|max:5120', // max 5MB
            'pdf_retribusi' => 'nullable|mimes:pdf|max:10240', // max 10MB
            'foto_retribusi' => 'nullable|mimes:jpg,jpeg,png|max:5120', // max 5MB
            'zip_retribusi' => 'nullable|mimes:zip|max:20480', // max 20MB
        ]);

        // CLEAN NILAI RETRIBUSI DARI MASKING
        // Dari "1.000.000" → "1000000"
        $nilai = str_replace('.', '', $request->nilai_retribusi);

        // SIMPAN FILE EXCEL (JIKA ADA)
        if ($request->hasFile('excel_retribusi')) {
            $file = $request->file('excel_retribusi');
            $path = $file->store('retribusi/excel', 'local');
            $p->excel_retribusi = $path;
        }

        // SIMPAN FILE PDF (JIKA ADA)
        if ($request->hasFile('pdf_retribusi')) {
            $file = $request->file('pdf_retribusi');
            $path = $file->store('retribusi/pdf', 'local');
            $p->pdf_retribusi = $path;
        }

        // SIMPAN FOTO (JIKA ADA)
        if ($request->hasFile('foto_retribusi')) {
            $file = $request->file('foto_retribusi');
            $path = $file->store('retribusi/foto', 'local');
            $p->foto_retribusi = $path;
        }

        // SIMPAN FILE ZIP (JIKA ADA)
        if ($request->hasFile('zip_retribusi')) {
            $file = $request->file('zip_retribusi');
            $path = $file->store('retribusi/zip', 'local');
            $p->zip_retribusi = $path;
        }

        // UPDATE NILAI RETRIBUSI
        $p->nilai_retribusi = $nilai;
        $p->save();

        $business_id = auth()->user()->business->id;
        // KIRIM EMAIL NOTIF KE KOORDINATOR RETRIBUSI
        if (auth()->user()->checkRole('retribusi')) {

            $admin = User::role("Koordinator#$business_id")->get();

            if ($admin->count() > 0) {
                $emailList = $admin->pluck('email')->toArray();
                \Mail::to($emailList)
                    ->send(new \App\Mail\RetribusiInputMail($p));
            }
        }

        $role = 'Retribusi#'.$business_id; // pastikan role tersedia

        $tracking = PbgTracking::updateOrCreate(
            [
                'pengajuan_id' => $p->id,
                'role' => $role
            ],
            [
                'user_id' => auth()->id(),
                'catatan' => "mengisi nilai retribusi",
                'status' => "proses",
                'verified_at' => now()
            ]
        );

        return response()->json(['status' => true]);
    }
  
    
    function detail_data(Request $request, $id)
    {
        $pengajuan = PengajuanPBG::findOrFail($id)->toArray();

        // Decode answers
        $answers = json_decode($pengajuan['answers'], true) ?? [];
        $sections = json_decode($pengajuan['questions'], true) ?? [];

        $results = [];

        foreach ($sections as $section) {

            $sec = [
                'caption' => $section['caption'],
                'rows' => [],
                'child' => [],
            ];

            /* ======================================================
            * LEVEL 1  (section -> questioner)
            * Key format: "caption__index"
            * ====================================================== */
            if (isset($section['questioner'])) {

                foreach ($section['questioner'] as $i => $q) {

                    $key = $section['caption'] . '__' . $i;

                    $val = $answers[$key]['value'] ?? null;

                    $sec['rows'][] = [
                        'question' => $q['question'],
                        'answer' => Helper::answerLabel($val),
                    ];
                }
            }


            /* ======================================================
            * LEVEL 2 (section -> child)
            * Key format: "caption > child_caption__index"
            * ====================================================== */
            if (isset($section['child'])) {

                foreach ($section['child'] as $child1) {

                    $sub = [
                        'caption' => $child1['caption'],
                        'rows' => [],
                        'child' => []
                    ];

                    // child1 langsung punya questioner
                    if (isset($child1['questioner'])) {
                        foreach ($child1['questioner'] as $i => $q) {

                            $key = $section['caption']
                                . ' > ' . $child1['caption']
                                . '__' . $i;

                            $val = $answers[$key]['value'] ?? null;

                            $sub['rows'][] = [
                                'question' => $q['question'],
                                'answer' => Helper::answerLabel($val)
                            ];
                        }
                    }


                    /* ======================================================
                    * LEVEL 3  (section -> child -> sub child)
                    * Key format:
                    * "caption > child_caption > subchild_caption__index"
                    * ====================================================== */
                    if (isset($child1['child'])) {

                        foreach ($child1['child'] as $child2) {

                            $sub2 = [
                                'caption' => $child2['caption'],
                                'rows' => []
                            ];

                            foreach ($child2['questioner'] as $i => $q) {

                                $key = $section['caption']
                                    . ' > ' . $child1['caption']
                                    . ' > ' . $child2['caption']
                                    . '__' . $i;

                                $val = $answers[$key]['value'] ?? null;

                                $sub2['rows'][] = [
                                    'question' => $q['question'],
                                    'answer' => Helper::answerLabel($val)
                                ];
                            }

                            $sub['child'][] = $sub2;
                        }
                    }

                    $sec['child'][] = $sub;
                }
            }

            $results[] = $sec;
        }

        $business_id = auth()->user()->business->id;
        $userList = User::where('business_id',$business_id)->orderByDesc('id')->get();

        return view('ciptakarya.detail_pbg', [
            'pengajuan' => $pengajuan,
            'inspectionResults' => $results,
            'userList'=>$userList
        ]);
    }

    public function simpanVerifikasi(Request $request)
    {
        $request->validate([
            'pengajuan_id' => 'required|integer',
            'hasil' => 'required|string',
            'catatan' => 'nullable|string',
        ]);

        $pengajuanId = $request->pengajuan_id;
        $rawHasil = $request->hasil; // 'sesuai' / 'tidak_sesuai'

        // map ke status yang konsisten di DB (optional)
        $statusMap = [
            'sesuai' => 'approved',
            'tidak_sesuai' => 'rejected'
        ];
        $status = $statusMap[$rawHasil] ?? $rawHasil;

        $role = auth()->user()->roles->first()->name ?? 'admin'; // pastikan role tersedia

        $tracking = PbgTracking::updateOrCreate(
            [
                'pengajuan_id' => $pengajuanId,
                'role' => $role
            ],
            [
                'user_id' => auth()->id(),
                'catatan' => $request->catatan,
                'status' => $status,
                'verified_at' => now()
            ]
        );

        $emailList = [];
        
        // === KIRIM EMAIL OTOMATIS JIKA ROLE = PEMERIKSA ===
        if ( auth()->user()->checkRole('pemeriksa') ) {
            
            $business_id = auth()->user()->business->id;
            // Cari user admin_retribusi
            $admin = User::role("Retribusi#$business_id")->get();
            if($admin->count() > 0){
                $emailList = $admin->pluck('email')->toArray();
                $pengajuan = PengajuanPBG::findorfail($pengajuanId);
    
                // Kirim email
                \Mail::to($emailList)->send(new \App\Mail\NotifVerifikasiRetribusi(
                    $pengajuan,
                    $tracking
                ));
            }
        }

        if ( auth()->user()->checkRole('retribusi') ) {
            
            $business_id = auth()->user()->business->id;
            // Cari user admin_retribusi
            $admin = User::role("Koordinator#$business_id")->get();
            if($admin->count() > 0){
                $emailList = $admin->pluck('email')->toArray();
                $pengajuan = PengajuanPBG::findorfail($pengajuanId);
    
                // Kirim email
                \Mail::to($emailList)->send(new \App\Mail\RetribusiInputMail(
                    $pengajuan
                ));
            }
        }

        if ( auth()->user()->checkRole('koordinator') ) {
            
            $business_id = auth()->user()->business->id;
            // Cari user admin_retribusi
            $admin = User::role("Kepala Bidang#$business_id")->get();
            if($admin->count() > 0){
                $emailList = $admin->pluck('email')->toArray();
                $pengajuan = PengajuanPBG::findorfail($pengajuanId);
    
                // Kirim email
                \Mail::to($emailList)->send(new \App\Mail\KepalaBidangNotifMail(
                    $pengajuan
                ));
            }
        }

        if ( auth()->user()->checkRole('kepala bidang') ) {
            
            $business_id = auth()->user()->business->id;
            // Cari user admin_retribusi
            $admin = User::role("Kepala Dinas#$business_id")->get();
            if($admin->count() > 0){
                $emailList = $admin->pluck('email')->toArray();
                $pengajuan = PengajuanPBG::findorfail($pengajuanId);
    
                // Kirim email
                \Mail::to($emailList)->send(new \App\Mail\KepalaDinasNotifMail(
                    $pengajuan
                ));
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Verifikasi tersimpan',
            // 'updated_pengajuan_status' => 'proses' // contoh jika mau kembalikan data tambahan
        ]);
    }

    public function timeline($id)
{
    $pengajuan = PengajuanPBG::find($id);

    if (!$pengajuan) {
        return response()->json([
            'status' => false,
            'message' => 'Data pengajuan tidak ditemukan'
        ]);
    }

    $flow = config('pbgflow');

    $timeline = [];

    foreach ($flow as $step) {

        // Normalisasi role flow: hilangkan spasi & lowercase
        $searchKey = strtolower(str_replace(' ', '', $step['role']));

        // Cari tracking berdasarkan LIKE
        $track = PbgTracking::where('pengajuan_id', $id)
            ->whereRaw("LOWER(REPLACE(role, ' ', '')) LIKE ?", ["%{$searchKey}%"])
            ->first();

        $row = [
            'role' => $step['role'],
            'label' => $step['label'],
            'desc'  => $step['desc'],
            'status' => 'pending',
            'catatan' => null,
            'verified_at' => null,
            'user' => null,
            'color' => 'red'
        ];

        if ($track) {
            $row['status']      = $track->status;
            $row['catatan']     = $track->catatan;
            $row['verified_at'] = $track->verified_at;
            $row['user']        = $track->user->username ?? null;
            $row['color']       = 'green';
        }

        $timeline[] = $row;
    }

    return response()->json([
        'status' => true,
        'timeline' => $timeline
    ]);
}



    public function riwayatVerifikasi($id)
    {
        $data = PbgTracking::where('pengajuan_id', $id)
            ->orderBy('verified_at', 'asc')
            ->get()
            ->map(function($t){
                return [
                    'role' => ucfirst(str_replace('_', ' ', $t->role)),
                    'status' => $t->status,
                    'catatan' => $t->catatan,
                    'verified_at' => $t->verified_at ? $t->verified_at->format('d/m/Y H:i') : '-',
                    'user' => $t->user->username ?? '-'
                ];
            });

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function disposisi(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $pengajuan = PengajuanPBG::findOrFail($id);
        $tujuan    = User::find($request->user_id);
        $pengirim  = auth()->user();

        // // simpan disposisi
        // $pengajuan->disposisi_ke = $tujuan->id;
        // $pengajuan->save();

        // kirim email
        \Mail::to($tujuan->email)->send(
            new \App\Mail\DisposisiPengajuanMail($pengajuan, $pengirim)
        );

        return response()->json(['status' => true]);
    }

    public function terbitkanDokumen($id)
    {
        $pengajuan = PengajuanPBG::findOrFail($id);

        // Kirim ke semua admin_berkas (tanpa nama admin)
        $business_id = auth()->user()->business->id;
        $emailAdmin = User::role("Admin#$business_id")->get();
        
        if ($emailAdmin->count() > 0) {
            $emailList = $emailAdmin->pluck('email')->toArray();
            \Mail::to($emailList)->send(new \App\Mail\DokumenTerbitMail($pengajuan));
        }


        if ($pengajuan->status == 'terbit') {
            return response()->json([
                'status' => false,
                'message' => 'Dokumen sudah diterbitkan sebelumnya.'
            ]);
        }

        // PROSES PENERBITAN (di sini bisa generate PDF / update status)
        $pengajuan->status = 'terbit';
        $pengajuan->tgl_terbit = now();
        $pengajuan->save();

        return response()->json(['status' => true]);
    }

    /**
     * Proxy endpoint untuk fetch SIMBG data (mengatasi CORS)
     */
    public function getSimbgDetail(Request $request)
    {
        try {
            $uid = $request->input('uid');
            
            if (!$uid) {
                return response()->json([
                    'success' => false,
                    'message' => 'UID tidak ditemukan'
                ], 400);
            }

            // Build URL untuk SIMBG API
            $url = "https://simbg.simtek-menanjak.com/api/data/pengajuan/batch-details";
            $queryString = http_build_query(['uids' => [$uid]]);
            $fullUrl = $url . '?' . $queryString;

            // Request ke SIMBG API menggunakan cURL
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $fullUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $error = curl_error($ch);
            curl_close($ch);

            if ($error) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal terhubung ke SIMBG: ' . $error
                ], 500);
            }

            if ($httpCode !== 200) {
                return response()->json([
                    'success' => false,
                    'message' => 'SIMBG API error: HTTP ' . $httpCode
                ], 500);
            }

            $data = json_decode($response, true);
            
            if (!$data) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid response from SIMBG'
                ], 500);
            }

            return response()->json($data);

        } catch (\Exception $e) {
            Log::error('SIMBG Proxy Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get statistics for public display
     */
    public function getStatistics()
    {
        try {
            $stats = [
                'pbg' => [
                    'proses' => PengajuanPBG::where('tipe', 'LIKE', '%PBG%')
                        ->whereNotIn('status', ['Terbit', 'terbit', 'TERBIT'])
                        ->count(),
                    'terbit' => PengajuanPBG::where('tipe', 'LIKE', '%PBG%')
                        ->whereIn('status', ['Terbit', 'terbit', 'TERBIT'])
                        ->count(),
                ],
                'slf' => [
                    'proses' => PengajuanPBG::where('tipe', 'LIKE', '%SLF%')
                        ->whereNotIn('status', ['Terbit', 'terbit', 'TERBIT'])
                        ->count(),
                    'terbit' => PengajuanPBG::where('tipe', 'LIKE', '%SLF%')
                        ->whereIn('status', ['Terbit', 'terbit', 'TERBIT'])
                        ->count(),
                ]
            ];

            return response()->json([
                'status' => true,
                'data' => $stats
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengambil statistik: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Public tracking untuk visitor (tanpa login)
     */
    public function publicTracking(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_permohonan' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Nomor permohonan harus diisi'
            ]);
        }

        $pengajuan = PengajuanPBG::where('no_permohonan', $request->no_permohonan)
            ->first();

        if (!$pengajuan) {
            return response()->json([
                'status' => false,
                'message' => 'Nomor permohonan tidak ditemukan dalam sistem'
            ]);
        }

        // Ambil tracking history
        $tracking = PbgTracking::where('pengajuan_id', $pengajuan->id)
            ->orderBy('created_at', 'asc')
            ->get();

        // Simplified flow untuk visitor
        $simplifiedFlow = $this->getSimplifiedFlow($tracking, $pengajuan->status);

        return response()->json([
            'status' => true,
            'data' => [
                'no_permohonan' => $pengajuan->no_permohonan,
                'nama_pemohon' => $pengajuan->nama_pemohon,
                'tipe' => $pengajuan->tipe,
                'status' => $pengajuan->status,
                'flow' => $simplifiedFlow
            ]
        ]);
    }

    /**
     * Generate simplified flow untuk visitor
     */
    private function getSimplifiedFlow($tracking, $currentStatus)
    {
        $stages = [
            ['name' => 'Pengajuan Diterima', 'icon' => 'fa-check-circle'],
            ['name' => 'Verifikasi Berkas', 'icon' => 'fa-file-text'],
            ['name' => 'Survey Lapangan', 'icon' => 'fa-map-marker'],
            ['name' => 'Perhitungan Retribusi', 'icon' => 'fa-calculator'],
            ['name' => 'Pemeriksaan Akhir', 'icon' => 'fa-clipboard-check'],
            ['name' => 'Penerbitan Sertifikat', 'icon' => 'fa-certificate'],
        ];

        $currentStageIndex = 0;

        // Tentukan stage berdasarkan status
        if (stripos($currentStatus, 'terbit') !== false) {
            $currentStageIndex = 5; // Semua tahap selesai
        } else if ($tracking->count() > 0) {
            $lastTracking = $tracking->last();
            
            if (stripos($lastTracking->status, 'verifikasi') !== false) {
                $currentStageIndex = 1;
            } else if (stripos($lastTracking->status, 'survey') !== false) {
                $currentStageIndex = 2;
            } else if (stripos($lastTracking->status, 'retribusi') !== false) {
                $currentStageIndex = 3;
            } else if (stripos($lastTracking->status, 'pemeriksaan') !== false) {
                $currentStageIndex = 4;
            }
        }

        $flow = [];
        foreach ($stages as $index => $stage) {
            $flow[] = [
                'name' => $stage['name'],
                'icon' => $stage['icon'],
                'status' => $index <= $currentStageIndex ? 'completed' : 'pending',
                'color' => $index <= $currentStageIndex ? 'green' : 'gray'
            ];
        }

        return $flow;
    }

    /**
     * Get visitor statistics
     */
    public function getVisitorStatistics()
    {
        try {
            $domain = request()->getHost();
            
            // Kunjungan hari ini
            $today = \App\Visitor::where('domain', $domain)
                ->whereDate('visited_date', today())
                ->count();
            
            // Total kunjungan
            $total = \App\Visitor::where('domain', $domain)
                ->count();

            return response()->json([
                'status' => true,
                'data' => [
                    'today' => $today,
                    'total' => $total
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengambil statistik kunjungan: ' . $e->getMessage()
            ], 500);
        }
    }

}
