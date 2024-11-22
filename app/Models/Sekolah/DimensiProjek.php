<?php

namespace App\Models\Sekolah;

use Illuminate\Database\Eloquent\Model;

class DimensiProjek extends Model
{
    protected $fillable = [
        // 'dimensi',
        'dimensi_id',
        'elemen',
        // 'subelemen',
    ];

    function dimensi(){
        return $this->belongsTo(DataDimensiID::class,'dimensi_id','id');
    }
}
