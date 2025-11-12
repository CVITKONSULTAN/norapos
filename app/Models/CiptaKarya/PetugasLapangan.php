<?php

namespace App\Models\CiptaKarya;

use Illuminate\Database\Eloquent\Model;

class PetugasLapangan extends Model
{
    protected $fillable = [
        'nama',
        'email',
        'bidang',
        'jabatan',
        'nip',
        'nik',
        'google_data',
        'fcm_token',
        'auth_token',
    ];

    protected $casts = ['google_data'=>'array'];

    function pengajuan(){
        return $this->hasMany(PengajuanPBG::class.'petugas_id','id');
    }
}
