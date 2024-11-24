<?php

namespace App\Models\Sekolah;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JurnalKelas extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'kelas_id',
        'mapel_id',
        'user_id',
        'jurnal',
        'tanggal',
        'nama_mapel',
    ];

    protected $cast = [
        'jurnal' => 'array'
    ];

    function mapel(){
        return $this->belongsTo(Mapel::class,'mapel_id','id');
    }
    function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
    function kelas(){
        return $this->belongsTo(Kelas::class,'kelas_id','id');
    }
}
