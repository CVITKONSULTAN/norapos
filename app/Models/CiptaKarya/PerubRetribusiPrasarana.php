<?php

namespace App\Models\CiptaKarya;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PerubRetribusiPrasarana extends Model
{
      use SoftDeletes;

    protected $table = 'perub_retribusi_prasaranas';

    protected $fillable = [
        'jenis_prasarana',
        'bangunan',
        'satuan',
        'harga_satuan',
        'pembangunan_baru',
        'rusak_berat',
        'rusak_sedang',
    ];
}
