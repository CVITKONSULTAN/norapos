<?php

namespace App\Http\Controllers\Models\Sekolah\Kokurikuler;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Sekolah\DimensiKokurikuler;
use DataTables;

class DimensiController extends Controller
{
    /**
     * Menampilkan halaman utama Dimensi Kokurikuler.
     */
    public function index()
    {
        return view('sekolah_sd.dimensi_kokurikuler');
    }

    /**
     * Mengambil data untuk DataTables.
     */
    public function data(Request $request)
    {
        $data = DimensiKokurikuler::orderByDesc('id')->get();
        return DataTables::of($data)->make(true);
    }

    /**
     * Simpan atau update data dimensi.
     */
    public function store(Request $request)
    {
        $request->validate([
            'profil' => 'required|string|max:255',
        ]);

        $dimensi = DimensiKokurikuler::updateOrCreate(
            ['id' => $request->id],
            ['profil' => $request->profil]
        );

        return response()->json([
            'status' => true,
            'message' => 'Dimensi berhasil disimpan',
            'data' => $dimensi
        ]);
    }

    /**
     * Ambil detail data dimensi untuk edit.
     */
    public function show($id)
    {
        $data = DimensiKokurikuler::find($id);
        if (!$data) {
            return response()->json(['status' => false, 'message' => 'Data tidak ditemukan']);
        }

        return response()->json(['status' => true, 'data' => $data]);
    }

    /**
     * Update data dimensi (opsional, karena store sudah handle updateOrCreate).
     */
    public function update(Request $request, $id)
    {
        $request->validate(['profil' => 'required|string|max:255']);

        $data = DimensiKokurikuler::find($id);
        if (!$data) {
            return response()->json(['status' => false, 'message' => 'Data tidak ditemukan']);
        }

        $data->update(['profil' => $request->profil]);

        return response()->json(['status' => true, 'message' => 'Data berhasil diperbarui']);
    }

    /**
     * Hapus data dimensi.
     */
    public function destroy($id)
    {
        $data = DimensiKokurikuler::find($id);
        if (!$data) {
            return response()->json(['status' => false, 'message' => 'Data tidak ditemukan']);
        }

        $data->delete();
        return response()->json(['status' => true, 'message' => 'Dimensi berhasil dihapus']);
    }
}
