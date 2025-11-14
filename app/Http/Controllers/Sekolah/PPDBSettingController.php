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
            // Format input date (single date)
            $data->tgl_penerimaan = $data->tgl_penerimaan
                ? Carbon::parse($data->tgl_penerimaan)->format('Y-m-d')
                : null;

            // Format tanggal_tes lama
            $data->tanggal_tes = $data->tanggal_tes
                ? Carbon::parse($data->tanggal_tes)->format('Y-m-d')
                : null;

            // Format JSON → array 
            $data->iq_days  = $data->iq_days ?: [];
            $data->map_days = $data->map_days ?: [];
            $data->sessions = $data->sessions ?: [];
            $data->capacity_per_session = $data->capacity_per_session ?? 14;
        }

        return response()->json([
            'status' => !!$data,
            'data' => $data
        ]);
    }


    public function store(Request $request) {
        $request->validate([
            'tahun_ajaran' => 'required|string|max:20',
            'tgl_penerimaan' => 'required|date',
            'jumlah_tagihan' => 'required|numeric|min:0',

            // Jadwal Test Dinamis
            'iq_days'  => 'nullable|array',
            'map_days' => 'nullable|array',
            'sessions' => 'nullable|array',
            'capacity_per_session' => 'nullable|numeric|min:1',
        ]);

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

                // 🎯 Tambahan untuk jadwal tes dinamis
                'iq_days'  => $request->iq_days ?? [],
                'map_days' => $request->map_days ?? [],
                'sessions' => $request->sessions ?? [],
                'capacity_per_session' => $request->capacity_per_session ?? 14,
            ]
        );

        return response()->json([
            'status'  => true,
            'message' => 'Pengaturan berhasil disimpan.',
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
