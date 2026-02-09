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
        'magic_link_token',
        'magic_link_expires_at',
    ];

    protected $casts = [
        'google_data' => 'array',
        'magic_link_expires_at' => 'datetime',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'magic_link_expires_at',
    ];

    function pengajuan(){
        return $this->hasMany(PengajuanPBG::class.'petugas_id','id');
    }
}
