<?php

namespace App\Http\Controllers\CiptaKarya;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\CiptaKarya\PengajuanPBG;
use App\Models\CiptaKarya\PetugasLapangan;
use App\Models\CiptaKarya\PbgTracking;
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
            'tgl_penugasan'
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
        ]);

        // CLEAN NILAI RETRIBUSI DARI MASKING
        // Dari "1.000.000" → "1000000"
        $nilai = str_replace('.', '', $request->nilai_retribusi);

        // SIMPAN FILE EXCEL (JIKA ADA)
        if ($request->hasFile('excel_retribusi')) {

            $file = $request->file('excel_retribusi');

            // Misal simpan di: storage/app/retribusi/excel/
            $path = $file->store('retribusi/excel', 'local');

            // Simpan path ke DB
            $p->excel_retribusi = $path;
        }

        // UPDATE NILAI RETRIBUSI
        $p->nilai_retribusi = $nilai;
        $p->save();

        // KIRIM EMAIL NOTIF KE KOORDINATOR RETRIBUSI
        if (auth()->user()->checkRole('retribusi')) {

            $business_id = auth()->user()->business->id;
            $admin = User::role("Koordinator#$business_id")->get();

            if ($admin->count() > 0) {
                $emailList = $admin->pluck('email')->toArray();
                Log::info("email kirim ke Koordinator ". json_encode($emailList));
                \Mail::to($emailList)
                    ->send(new \App\Mail\RetribusiInputMail($p));
            }
        }

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

        return view('ciptakarya.detail_pbg', [
            'pengajuan' => $pengajuan,
            'inspectionResults' => $results
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

}
