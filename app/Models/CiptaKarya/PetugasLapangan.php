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
        'nik'
    ];
}
