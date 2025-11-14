<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class JadwalTesExport implements FromView
{
    protected $tanggal;

    public function __construct($tanggal)
    {
        $this->tanggal = $tanggal;
    }

    public function view(): View
    {
        // AMBIL SEMUA PESERTA IQ ATAU MAP UNTUK TANGGAL INI
        $rows = DB::table('ppdb_test_schedules as s')
            ->join('p_p_d_b_sekolahs as p', 'p.kode_bayar', '=', 's.kode_bayar')
            ->select(
                'p.nama',
                'p.kode_bayar',
                DB::raw("JSON_UNQUOTE(JSON_EXTRACT(p.detail, '$.no_hp')) as no_hp"),
                's.*'
            )
            ->where(function ($q) {
                $q->where('s.iq_date', $this->tanggal)
                  ->orWhere('s.map_date', $this->tanggal);
            })
            ->get();

        $result = [];

        foreach ($rows as $item) {

            // ============================
            // TES IQ
            // ============================
            if ($item->iq_date == $this->tanggal) {

                $hari = Carbon::parse($item->iq_date)->translatedFormat('d F Y');
                $jam  = Carbon::parse($item->iq_start_time)->format('H:i')
                      . " - " .
                        Carbon::parse($item->iq_end_time)->format('H:i');

                if (!isset($result[$hari]['IQ'])) $result[$hari]['IQ'] = [];
                if (!isset($result[$hari]['IQ'][$jam])) $result[$hari]['IQ'][$jam] = [];

                $result[$hari]['IQ'][$jam][] = [
                    'nama'        => $item->nama,
                    'kode_bayar'  => $item->kode_bayar,
                    'no_hp'       => $item->no_hp,
                ];
            }

            // ============================
            // TES PEMETAAN (MAP)
            // ============================
            if ($item->map_date == $this->tanggal) {

                $hari = Carbon::parse($item->map_date)->translatedFormat('d F Y');
                $jam  = Carbon::parse($item->map_start_time)->format('H:i')
                      . " - " .
                        Carbon::parse($item->map_end_time)->format('H:i');

                if (!isset($result[$hari]['MAP'])) $result[$hari]['MAP'] = [];
                if (!isset($result[$hari]['MAP'][$jam])) $result[$hari]['MAP'][$jam] = [];

                $result[$hari]['MAP'][$jam][] = [
                    'nama'        => $item->nama,
                    'kode_bayar'  => $item->kode_bayar,
                    'no_hp'       => $item->no_hp,
                ];
            }
        }

        return view('exports.jadwal_test_ppdb_excel', [
            'data'    => $result,
            'tanggal' => $this->tanggal
        ]);
    }
}
