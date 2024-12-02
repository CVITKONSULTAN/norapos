<?php

namespace App\Models\Sekolah;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mapel extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nama',
        'kategori',
        'lingkup_materi',
        'tujuan_pembelajaran',
        'business_id',
        'kelas',
        'orders'
    ];

    protected $casts = [
        'lingkup_materi' => 'array',
        'tujuan_pembelajaran' => 'array',
    ];

    function Business(){
        return $this->belongsTo(Business::class,'business_id','id');
    }
}
