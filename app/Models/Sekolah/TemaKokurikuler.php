<?php

namespace App\Models\Sekolah;

use Illuminate\Database\Eloquent\Model;

class TemaKokurikuler extends Model
{
    protected $fillable = [
        'tema',
        'aspek_nilai',
        'dimensi_list',
        'kelas',
        'tahun_ajaran',
        'semester',
        'history_apply',
    ];

    protected $casts = [
        'dimensi_list'=>'array',
        'history_apply'=>'array'
    ];
}
