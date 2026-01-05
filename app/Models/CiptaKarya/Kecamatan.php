<?php

namespace App\Models\CiptaKarya;

use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    protected $table = 'kecamatans';

    protected $fillable = [
        'kode',
        'nama',
    ];
}
