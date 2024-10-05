<?php

namespace App\Models\Sekolah;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Siswa extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nisn',
        'nama',
        'detail'
    ];

    protected $casts = [
        'detail' => 'array',
    ];

}
