<?php

namespace App\Models\Sekolah;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use \App\Models\Sekolah\Siswa;
use \App\Models\Sekolah\Kelas;

class KelasSiswa extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'siswa_id',
        'kelas_id',
        'catatan_tengah',
        'catatan_akhir',
        'kesimpulan',
    ];
    
    function siswa(){
        return $this->belongsTo(Siswa::class,'siswa_id','id');
    }
    function kelas(){
        return $this->belongsTo(Kelas::class,'kelas_id','id');
    }
    
}
