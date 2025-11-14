<?php

namespace App\Models\Sekolah;

use Illuminate\Database\Eloquent\Model;

class PPDBSetting extends Model
{
    protected $table = 'ppdb_settings';

    protected $fillable = [
        'close_ppdb',
        'tgl_penerimaan',
        'min_bulan',
        'min_tahun',
        'tahun_ajaran',
        'jumlah_tagihan',
        'nama_bank',
        'no_rek',
        'atas_nama',
        'tanggal_tes',
        'tempat_tes',
        'iq_days',
        'map_days',
        'sessions',
    ];

    protected $casts = [
        'close_ppdb' => 'boolean',
        'tgl_penerimaan' => 'date',
        'close_ppdb' => 'boolean',
        'iq_days' => 'array',
        'map_days' => 'array',
        'sessions' => 'array',
    ];
}
