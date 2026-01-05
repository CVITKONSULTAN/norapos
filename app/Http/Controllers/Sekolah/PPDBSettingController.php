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

            $data->tgl_tutup_penerimaan = $data->tgl_tutup_penerimaan
            ? Carbon::parse($data->tgl_tutup_penerimaan)->format('Y-m-d')
            : null;

        $data->tgl_masuk_sekolah = $data->tgl_masuk_sekolah
            ? Carbon::parse($data->tgl_masuk_sekolah)->format('Y-m-d')
            : null;

        }

        return response()->json([
            'status' => !!$data,
            'data' => $data
        ]);
    }


    public function store(Request $request)
    {
        // Validasi dasar
        $request->validate([
            'tahun_ajaran' => 'required|string|max:20',
            'tgl_penerimaan' => 'required|date',
            'jumlah_tagihan' => 'required|numeric|min:0',
            'session_capacities' => 'nullable|string', // JSON string
            'tgl_tutup_penerimaan' => 'nullable|date',
            'tgl_masuk_sekolah' => 'nullable|date',
        ]);

        $tglTutup = $request->tgl_tutup_penerimaan ? Carbon::parse($request->tgl_tutup_penerimaan)->format('Y-m-d') : null;
        $tglMasuk = $request->tgl_masuk_sekolah ? Carbon::parse($request->tgl_masuk_sekolah)->format('Y-m-d') : null;

        // Format tanggal
        $tglPenerimaan = Carbon::parse($request->tgl_penerimaan)->format('Y-m-d');
        $tglTes = $request->tanggal_tes ? Carbon::parse($request->tanggal_tes)->format('Y-m-d') : null;

        // Convert JSON string → PHP array
        $sessionCapacities = [];
        if ($request->session_capacities) {
            try {
                $sessionCapacities = json_decode($request->session_capacities, true);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Format session_capacities tidak valid.'
                ]);
            }
        }

        // Simpan / update
        $setting = PPDBSetting::updateOrCreate(
            ['id' => $request->id],
            [
                'tahun_ajaran'      => $request->tahun_ajaran,
                'tgl_penerimaan'    => $tglPenerimaan,
                'jumlah_tagihan'    => $request->jumlah_tagihan,
                'nama_bank'         => $request->nama_bank,
                'no_rek'            => $request->no_rek,
                'atas_nama'         => $request->atas_nama,
                'tanggal_tes'       => $tglTes,
                'tempat_tes'        => $request->tempat_tes,

                'tgl_tutup_penerimaan' => $tglTutup,
                'tgl_masuk_sekolah' => $tglMasuk,

                // 🎯 SIMPAN FORMAT BARU
                'session_capacities' => $sessionCapacities,
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
        // 1. Ambil semua tanggal (iq + map) tapi digabung jadi satu filter
        $availableDates = DB::table('ppdb_test_schedules')
            ->select('iq_date', 'map_date')
            ->get()
            ->flatMap(fn($x) => [$x->iq_date, $x->map_date])
            ->unique()
            ->filter()
            ->sort()
            ->values()
            ->toArray();

        if (count($availableDates) == 0) {
            return view('sekolah_sd.jadwal_test_ppdb', [
                'data'   => [],
                'filter' => null,
                'dates'  => [],
            ]);
        }

        // 2. Filter tanggal yang dipilih
        $filter = $request->tanggal ?? $availableDates[0];

        // 3. Ambil data peserta IQ atau MAP yang sesuai tanggal
        $rows = DB::table('ppdb_test_schedules as s')
            ->join('p_p_d_b_sekolahs as p', 'p.kode_bayar', '=', 's.kode_bayar')
            ->select(
                'p.nama', 'p.kode_bayar',
                DB::raw("JSON_UNQUOTE(JSON_EXTRACT(p.detail, '$.no_hp')) as no_hp"),
                's.*'
            )
            ->where(function($q) use ($filter) {
                $q->where('s.iq_date', $filter)
                ->orWhere('s.map_date', $filter);
            })
            ->get();

        // 4. Kembalikan format: IQ dan MAP dipisah sesi
        $result = [];

        foreach ($rows as $item) {

            // IQ
            if ($item->iq_date == $filter) {

                $hari = Carbon::parse($item->iq_date)->translatedFormat('d F Y');
                $jam  = Carbon::parse($item->iq_start_time)->format('H:i')
                    ." - ".
                    Carbon::parse($item->iq_end_time)->format('H:i');

                $result[$hari]['IQ'][$jam][] = [
                    'nama' => $item->nama,
                    'kode_bayar' => $item->kode_bayar,
                    'no_hp' => $item->no_hp,
                ];
            }

            // MAP
            if ($item->map_date == $filter) {

                $hari = Carbon::parse($item->map_date)->translatedFormat('d F Y');
                $jam  = Carbon::parse($item->map_start_time)->format('H:i')
                    ." - ".
                    Carbon::parse($item->map_end_time)->format('H:i');

                $result[$hari]['MAP'][$jam][] = [
                    'nama' => $item->nama,
                    'kode_bayar' => $item->kode_bayar,
                    'no_hp' => $item->no_hp,
                ];
            }
        }

        return view('sekolah_sd.jadwal_test_ppdb', [
            'data'   => $result,
            'filter' => $filter,
            'dates'  => $availableDates
        ]);
    }
    
    public function exportExcelJadwalPPDB(Request $request)
    {
        $tanggal = $request->tanggal;

        $namaFile = "Jadwal-Test-PPDB-$tanggal.xlsx";

        return Excel::download(new JadwalTesExport($tanggal), $namaFile);
    }

}
