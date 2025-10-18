<?php

namespace App\Http\Controllers\CiptaKarya;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CiptaKarya\PengajuanPBG;
use App\Models\CiptaKarya\PetugasLapangan;
use Validator;
use DataTables;

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
     * List Datatables PBG
     *
     * @return \Illuminate\Http\Response
     */
    public function list_data_pbg()
    {
        return DataTables::of(PengajuanPBG::query())->make(true);
    }

    /**
     * List Datatables Petugas
     *
     * @return \Illuminate\Http\Response
     */
    public function list_data_petugas()
    {
        return DataTables::of(PetugasLapangan::query())->make(true);
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
}
