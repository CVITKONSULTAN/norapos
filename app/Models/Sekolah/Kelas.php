<?php

namespace App\Models\Sekolah;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kelas extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'tahun_ajaran',
        'semester',
        'nama_kelas',
        'nama_wali_kelas',
        'nbm_wali_kelas',
        'wali_kelas_id',
    ];

    public static function getGroupBy($column){
        return self::groupBy($column)->select($column)->get()->pluck($column);
    }
    
}
