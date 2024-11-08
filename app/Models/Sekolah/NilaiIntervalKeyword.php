<?php

namespace App\Models\Sekolah;

use Illuminate\Database\Eloquent\Model;

class NilaiIntervalKeyword extends Model
{
    protected $fillable = [
        'nilai_minimum',
        'nilai_maksimum',
        'formatter_string',
        'tipe'
    ];
}
