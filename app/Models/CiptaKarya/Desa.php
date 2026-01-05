<?php

namespace App\Models\CiptaKarya;

use Illuminate\Database\Eloquent\Model;

class Desa extends Model
{
    protected $table = 'desas';

    protected $fillable = [
        'kecamatan_id',
        'kode',
        'nama',
    ];
}
