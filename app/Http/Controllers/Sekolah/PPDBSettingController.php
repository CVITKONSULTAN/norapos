<?php

namespace App\Http\Controllers\Sekolah;

use App\Http\Controllers\Controller;
use App\Models\Sekolah\PPDBSetting;
use Illuminate\Http\Request;
use DataTables;
use Carbon\Carbon;

class PPDBSettingController extends Controller
{
    public function index() {
        return view('sekolah.ppdb_setting.index');
    }

    public function data() {
        $data = PPDBSetting::orderByDesc('id')->get();
        return DataTables::of($data)->make(true);
    }

    public function show($id) {
        $data = PPDBSetting::find($id);
        if ($data) {
            // ✅ Format tanggal agar cocok untuk <input type="date">
            $data->tgl_penerimaan = $data->tgl_penerimaan
                ? Carbon::parse($data->tgl_penerimaan)->format('Y-m-d')
                : null;

            $data->tanggal_tes = $data->tanggal_tes
                ? Carbon::parse($data->tanggal_tes)->format('Y-m-d')
                : null;
        }
        return response()->json(['status' => !!$data, 'data' => $data]);
    }

    public function store(Request $request) {
        // ✅ Validasi dasar
        $request->validate([
            'tahun_ajaran' => 'required|string|max:20',
            'tgl_penerimaan' => 'required|date',
            'jumlah_tagihan' => 'required|numeric|min:0',
        ]);

        // ✅ Format tanggal agar tersimpan konsisten
        $tglPenerimaan = Carbon::parse($request->tgl_penerimaan)->format('Y-m-d');
        $tglTes = $request->tanggal_tes ? Carbon::parse($request->tanggal_tes)->format('Y-m-d') : null;

        $setting = PPDBSetting::updateOrCreate(
            ['id' => $request->id],
            [
                'tahun_ajaran'   => $request->tahun_ajaran,
                'tgl_penerimaan' => $tglPenerimaan,
                'jumlah_tagihan' => $request->jumlah_tagihan,
                'nama_bank'      => $request->nama_bank,
                'no_rek'         => $request->no_rek,
                'atas_nama'      => $request->atas_nama,
                'tanggal_tes'    => $tglTes,
                'tempat_tes'     => $request->tempat_tes,
            ]
        );

        // 🔹 Jangan ubah status close_ppdb di sini
        // Semua data baru tetap tertutup, dan hanya toggle() yang mengatur open/close

        return response()->json([
            'status'  => true,
            'message' => 'Periode berhasil disimpan (dalam status tertutup).',
            'data'    => $setting
        ]);
    }

    public function toggle(Request $request) {
        $id = $request->id;
        $target = PPDBSetting::find($id);
        if(!$target) return response()->json(['status'=>false, 'message'=>'Data tidak ditemukan']);

        // ✅ Trigger buka: tutup semua periode lain
        if($request->close_ppdb == 0) {
            PPDBSetting::where('id', '!=', $id)->update(['close_ppdb' => true]);
            $target->close_ppdb = false; // buka periode ini
        } 
        // ✅ Trigger tutup: hanya tutup periode ini
        else {
            $target->close_ppdb = true;
        }

        $target->save();

        return response()->json([
            'status'  => true,
            'message' => $target->close_ppdb 
                ? 'Periode berhasil ditutup.' 
                : 'Periode berhasil dibuka (periode lain otomatis tertutup).'
        ]);
    }

    public function destroy($id) {
        $setting = PPDBSetting::find($id);
        if (!$setting) {
            return response()->json(['status'=>false, 'message'=>'Data tidak ditemukan']);
        }

        $setting->delete();
        return response()->json(['status'=>true, 'message'=>'Periode berhasil dihapus.']);
    }
}
