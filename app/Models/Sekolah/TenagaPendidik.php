<?php

namespace App\Models\Sekolah;

use Illuminate\Database\Eloquent\Model;
use App\User;

class TenagaPendidik extends Model
{
    protected $fillable = [
        'user_id',
        'nip',
        'nama',
        'no_hp',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'bidang_studi',
        'status',
        'alamat',
        'keterangan',
        'pendidikan_terakhir',
        'foto',
        'nik',
        'tahun_sertifikasi',
        'nbm',
        'nuptk',
        'pangkat_golongan',
        'jabatan',
        'mulai_bertugas',
        'status_perkawinan',
        'status_kepegawaian',
        'mapel_id_list',
        'kelas_khusus',
    ];

    protected $casts = [
        'mapel_id_list' => 'array',
        'kelas_khusus' => 'array'
    ];

    function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    function mapel_list(){
        try {
            $list = json_decode($this->mapel_id_list,true);
            if(empty($list))
            $list = [];
        } catch (\Throwable $th) {
            $list = [];
        }
        // dd($list);
        return $list;
    }

    function getUniqKelasKhusus(){
        $list_kelas = [];
        foreach($this->kelas_khusus ?? [] as $item){
            foreach($item as $val){
                if(!in_array($val,$list_kelas)){
                    $list_kelas[] = $val;
                }
            }
        }
        return $list_kelas;
    }
}
