<?php

namespace App\Http\Controllers\CiptaKarya;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CiptaKarya\PengajuanPBG;
use App\Models\CiptaKarya\PetugasLapangan;
use Validator;
use DataTables;
use DB;

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
        $petugas = PetugasLapangan::where('email',$request->email)->first();
        if(!$petugas)
            return response()
            ->json(
                ['status' => false, 'message' => 'Email anda belum terdaftar pada data admin']
            ,400);
        
        $petugas->google_data = $request->google_data;

        $petugas->save();
        return response()
            ->json(['status' => true, 'message' => 'OK']);
    }

    public function update_petugas(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:pengajuan_pbg,id',
            'petugas_id' => 'required|exists:petugas_lapangans,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        }

        $pengajuan = PengajuanPBG::find($request->id);
        $petugas = PetugasLapangan::find($request->petugas_id);

        $pengajuan->petugas_id = $petugas->id;
        $pengajuan->petugas = $petugas->nama ?? $petugas->email; // simpan juga nama/email

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



    

}
