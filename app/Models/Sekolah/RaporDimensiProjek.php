<?php

namespace App\Models\Sekolah;

use Illuminate\Database\Eloquent\Model;

class RaporDimensiProjek extends Model
{
    protected $fillable = [
        'rapor_projek_id',
        'dimensi_id',
        'dimensi_text',
        'subelemen_fase',
    ];

    protected $casts = ['subelemen_fase'=>'array'];

    function projek(){
        return $this->belongsTo(RaporProjek::class,'rapor_projek_id','id');
    }
}
