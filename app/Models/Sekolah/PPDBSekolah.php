<?php

namespace App\Models\Sekolah;

use Illuminate\Database\Eloquent\Model;

class PPDBSekolah extends Model
{
    protected $fillable = [
        'nama',
        'detail',
        'status_siswa',
        'keterangan',
        'status_bayar',
        'bank_pembayaran',
        'bukti_pembayaran',
        'kode_bayar'
    ];

    protected $casts = [
        'detail' => 'array',
        'bukti_pembayaran' => 'array',
    ];
    
}
