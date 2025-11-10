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
        'kode_bayar',
        'validated_by',
        'validated_at',
        'ppdb_setting_id',
    ];

    protected $casts = [
        'detail' => 'array',
        'bank_pembayaran' => 'array',
        'bukti_pembayaran' => 'array',
        'validated_at' => 'datetime',
    ];

    public function validator()
    {
        return $this->belongsTo(\App\User::class, 'validated_by');
    }

     public function ppdb_setting()
    {
        return $this->belongsTo(\App\Models\Sekolah\PPDBSetting::class);
    }
    
}
