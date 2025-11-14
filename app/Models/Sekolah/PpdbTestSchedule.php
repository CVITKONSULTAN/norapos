<?php

namespace App\Models\Sekolah;
use Illuminate\Database\Eloquent\Model;

class PpdbTestSchedule extends Model
{

    protected $fillable = [
        'kode_bayar',
        'iq_date', 'iq_start_time', 'iq_end_time',
        'map_date', 'map_start_time', 'map_end_time',
    ];

    public function peserta()
    {
        return $this->belongsTo(PpdbSekolah::class, 'kode_bayar', 'kode_bayar');
    }
}
