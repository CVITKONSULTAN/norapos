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
    ];

    function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
