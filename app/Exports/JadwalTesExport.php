<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class JadwalTesExport implements FromView
{
    protected $tanggal;
    protected $tipe;

    public function __construct($tanggal, $tipe)
    {
        $this->tanggal = $tanggal;
        $this->tipe = $tipe;
    }

    public function view(): View
    {
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

        if ($this->tipe === 'map') {
            $query->where('s.map_date', $this->tanggal);
        } else {
            $query->where('s.iq_date', $this->tanggal);
        }

        $rows = $query->orderBy('s.iq_start_time')->get();

        $result = [];

        foreach ($rows as $item) {

            if ($this->tipe === 'map') {
                $hari = Carbon::parse($item->map_date)->translatedFormat('d F Y');
                $jam  = Carbon::parse($item->map_start_time)->format('H:i') . " - " .
                        Carbon::parse($item->map_end_time)->format('H:i');
            } else {
                $hari = Carbon::parse($item->iq_date)->translatedFormat('d F Y');
                $jam  = Carbon::parse($item->iq_start_time)->format('H:i') . " - " .
                        Carbon::parse($item->iq_end_time)->format('H:i');
            }

            if (!isset($result[$hari])) $result[$hari] = [];
            if (!isset($result[$hari][$jam])) $result[$hari][$jam] = [];

            $result[$hari][$jam][] = [
                'nama' => $item->nama,
                'no_hp' => $item->no_hp,
                'kode_bayar' => $item->kode_bayar,
                'pemetaan' => [
                    'tanggal' => Carbon::parse($item->map_date)->translatedFormat('d F Y'),
                    'jam'     => Carbon::parse($item->map_start_time)->format('H:i') . " - " .
                                Carbon::parse($item->map_end_time)->format('H:i'),
                ]
            ];
        }

        return view('exports.jadwal_test_ppdb_excel', [
            'data' => $result,
            'tanggal' => $this->tanggal,
            'tipe' => $this->tipe
        ]);
    }
}
