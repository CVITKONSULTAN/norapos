<?php

namespace App\Models\Sekolah;

use \App\Models\Sekolah\Siswa;
use \App\Models\Sekolah\Kelas;
use \App\Models\Sekolah\Mapel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NilaiSiswa extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'siswa_id',
        'kelas_id',
        'mapel_id',
        'nilai_tp',
        'nilai_akhir_tp',
        'nilai_sumatif',
        'nilai_akhir_sumatif',
        'nilai_rapor',
        
        'kolom_max_tp',
        'nilai_max_tp',
        'catatan_max_tp',
        'kolom_min_tp',
        'nilai_min_tp',
        'catatan_min_tp',
    ];
    
    function siswa(){
        return $this->belongsTo(Siswa::class,'siswa_id','id');
    }
    function kelas(){
        return $this->belongsTo(Kelas::class,'kelas_id','id');
    }
    function mapel(){
        return $this->belongsTo(Mapel::class,'mapel_id','id');
    }

}
