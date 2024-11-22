<?php

namespace App\Models\Sekolah;

use Illuminate\Database\Eloquent\Model;

class RaporProjek extends Model
{
    protected $fillable = [
        'nama',
        'deskripsi',
        'elemen_list',
        'kelas',
    ];

    function dimensi(){
        return $this->hasMany(RaporDimensiProjek::class,'rapor_projek_id','id');
    }
}
