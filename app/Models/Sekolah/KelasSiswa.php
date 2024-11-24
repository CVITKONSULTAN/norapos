<?php

namespace App\Models\Sekolah;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use \App\Models\Sekolah\Siswa;
use \App\Models\Sekolah\Kelas;
use \App\Models\Sekolah\TenagaPendidik;

class KelasSiswa extends Model
{
    // use SoftDeletes;

    protected $fillable = [
        'siswa_id',
        'kelas_id',
        'catatan_tengah',
        'catatan_akhir',
        'kesimpulan',
        'hadir',
        'izin',
        'sakit',
        'tanpa_keterangan',
        'project_id_list',
        'nilai_projek',
        'hitungan_sistem'
    ];

    protected $casts = [
        'project_id_list'=>'array',
        'nilai_projek'=>'array',
        'hitungan_sistem'=>'array',
    ];


    function siswa(){
        return $this->belongsTo(Siswa::class,'siswa_id','id');
    }
    function kelas(){
        return $this->belongsTo(Kelas::class,'kelas_id','id');
    }

    function projects(){
        $data = [];
        $project_id_list = [];
        try {
            $project_id_list = json_decode($this->project_id_list,true);
            if(empty($project_id_list)) $project_id_list = [];
        } catch (\Throwable $th) {
            $project_id_list = [];
        }
        return RaporProjek::whereIn('id',$project_id_list)->get();
    }
    
}
