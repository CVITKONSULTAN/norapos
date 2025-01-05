<?php

namespace App\Models\Sekolah;

use Illuminate\Database\Eloquent\Model;

class PPDBSekolah extends Model
{
    protected $fillable = [
        'nama',
        'detail',
        'status_siswa',
        'keterangan'
    ];

    protected $casts = [
        'detail' => 'array',
    ];
    
}
