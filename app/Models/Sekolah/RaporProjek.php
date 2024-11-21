<?php

namespace App\Models\Sekolah;

use Illuminate\Database\Eloquent\Model;

class RaporProjek extends Model
{
    protected $fillable = [
        'nama',
        'deskripsi',
        'elemen_list',
    ];
}
