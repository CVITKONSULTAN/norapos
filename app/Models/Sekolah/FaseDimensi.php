<?php

namespace App\Models\Sekolah;

use Illuminate\Database\Eloquent\Model;

class FaseDimensi extends Model
{
    protected $fillable = [
        'subelemen_index',
        'subelemen',
        'fase_a',
        'fase_b',
        'fase_c',
        'keterangan',
        'elemen_id',
    ];

    function elemen(){
        return $this->belongsTo(DimensiProjek::class,'elemen_id','id');
    }
}
