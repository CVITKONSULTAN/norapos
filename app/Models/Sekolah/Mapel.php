<?php

namespace App\Models\Sekolah;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mapel extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nama',
        'kategori',
        'lingkup_materi',
        'tujuan_pembelajaran',
    ];

    protected $casts = [
        'lingkup_materi' => 'array',
        'tujuan_pembelajaran' => 'array',
    ];
}
