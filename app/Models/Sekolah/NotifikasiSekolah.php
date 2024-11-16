<?php

namespace App\Models\Sekolah;

use \App\User;

use Illuminate\Database\Eloquent\Model;

class NotifikasiSekolah extends Model
{
    protected $fillable = [
        'user_id',
        'tipe',
        'judul',
        'deskripsi',
        'data',
        'read_at'
    ];

    function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
