<?php

namespace App\Models\Sekolah;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EkskulSiswa extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'siswa_id',
        'kelas_id',
        'ekskul_id',
        'keterangan'
    ];

    function siswa(){
        return $this->belongsTo(Siswa::class,'siswa_id','id');
    }
    function kelas(){
        return $this->belongsTo(Kelas::class,'kelas_id','id');
    }
    function ekskul(){
        return $this->belongsTo(Ekstrakurikuler::class,'ekskul_id','id');
    }
}
