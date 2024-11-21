<?php

namespace App\Models\Sekolah;

use Illuminate\Database\Eloquent\Model;

class FaseDimensi extends Model
{
    protected $fillable = [
        'subelemen_index',
        'keterangan',
        'elemen_id',
    ];
}
