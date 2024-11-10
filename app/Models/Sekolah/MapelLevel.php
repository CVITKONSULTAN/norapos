<?php

namespace App\Models\Sekolah;

use Illuminate\Database\Eloquent\Model;

class MapelLevel extends Model
{
    protected $fillable = [
        'kelas',
        'lingkup_materi',
        'tujuan_pembelajaran',
        'mapels_id'
    ];

    function mapel(){
        return $this->belongsTo(Mapel::class,'mapels_id','id');
    }
}
