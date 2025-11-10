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
    ];
}
