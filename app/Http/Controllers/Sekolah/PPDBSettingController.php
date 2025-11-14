<?php

namespace App\Http\Controllers\Sekolah;

use App\Http\Controllers\Controller;
use App\Models\Sekolah\PPDBSetting;
use Illuminate\Http\Request;
use DataTables;
use Carbon\Carbon;
use DB;
use Excel;
use App\Exports\JadwalTesExport;

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

    public function hariDetail(Request $request)
    {
        // ------------------------------
        // 1) Ambil semua tanggal tes yang tersedia dari DB
        // ------------------------------
        $availableDates = DB::table('ppdb_test_schedules')
            ->select('iq_date', 'map_date')
            ->get()
            ->flatMap(function ($item) {
                return [$item->iq_date, $item->map_date];
            })
            ->unique()
            ->filter()
            ->sort()
            ->values()
            ->toArray();

        // Jika belum ada data sama sekali
        if (count($availableDates) == 0) {
            return view('sekolah_sd.jadwal_test_ppdb', [
                'data' => [],
                'filter' => null,
                'tipe' => 'iq',
                'dates' => []
            ]);
        }

        // ------------------------------
        // 2) Ambil filter user
        // ------------------------------
        $filter = $request->tanggal ?: $availableDates[0];
        $tipe = $request->tipe ?? 'iq'; // iq | map

        // ------------------------------
        // 3) Query data peserta + nomor HP
        // ------------------------------
        $query = DB::table('ppdb_test_schedules as s')
            ->join('p_p_d_b_sekolahs as p', 'p.kode_bayar', '=', 's.kode_bayar')
            ->select(
                'p.nama',
                'p.kode_bayar',
                DB::raw("JSON_UNQUOTE(JSON_EXTRACT(p.detail, '$.no_hp')) as no_hp"),
                's.iq_date',
                's.iq_start_time',
                's.iq_end_time',
                's.map_date',
                's.map_start_time',
                's.map_end_time'
            );

        // ------------------------------
        // 4) Filter berdasarkan tipe tes
        // ------------------------------
        if ($tipe === 'map') {
            $query->where('s.map_date', $filter);
        } else {
            $query->where('s.iq_date', $filter);
        }

        $rows = $query->orderBy('s.iq_start_time')->get();
        // ------------------------------
        // 5) Susun hasil: Hari → Sesi → Peserta
        // ------------------------------
        $result = [];

        foreach ($rows as $item) {

            // Tentukan atribut utama sesuai tipe tes
            if ($tipe === 'map') {
                $hariTanggal = $item->map_date;
                $start = $item->map_start_time;
                $end   = $item->map_end_time;
            } else {
                $hariTanggal = $item->iq_date;
                $start = $item->iq_start_time;
                $end   = $item->iq_end_time;
            }

            // Hari
            $hari = Carbon::parse($hariTanggal)->translatedFormat('d F Y');

            // Sesi
            $jam = Carbon::parse($start)->format('H:i') . " - " .
                Carbon::parse($end)->format('H:i');

            if (!isset($result[$hari])) {
                $result[$hari] = [];
            }

            if (!isset($result[$hari][$jam])) {
                $result[$hari][$jam] = [];
            }

            // Isi data peserta
            $result[$hari][$jam][] = [
                'nama'       => $item->nama,
                'kode_bayar' => $item->kode_bayar,
                'no_hp'      => $item->no_hp,

                // Jadwal pemetaan selalu ditampilkan (referensi)
                'pemetaan' => [
                    'tanggal' => Carbon::parse($item->map_date)->translatedFormat('d F Y'),
                    'jam'     => Carbon::parse($item->map_start_time)->format('H:i') . " - " .
                                Carbon::parse($item->map_end_time)->format('H:i'),
                ]
            ];
        }

        // ------------------------------
        // 6) Return ke view
        // ------------------------------
        return view('sekolah_sd.jadwal_test_ppdb', [
            'data'   => $result,
            'filter' => $filter,
            'tipe'   => $tipe,
            'dates'  => $availableDates
        ]);
    }

    
    public function exportExcelJadwalPPDB(Request $request)
    {
        $tanggal = $request->tanggal;
        $tipe = $request->tipe ?? 'iq';

        $namaFile = "Jadwal-Test-PPDB-$tanggal.xlsx";

        return Excel::download(new JadwalTesExport($tanggal, $tipe), $namaFile);
    }

}
