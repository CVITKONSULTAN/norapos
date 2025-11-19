<?php

namespace App\Models\Sekolah;

use Illuminate\Database\Eloquent\Model;

class SekolahActivity extends Model
{
    protected $fillable = [
        'user_id',
        'business_id',
        'module',
        'action',
        'reference_id',
        'reference_type',
        'payload',
        'ip_address',
        'user_agent'
    ];

    protected $casts = [
        'payload' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function business()
    {
        return $this->belongsTo(\App\Business::class);
    }
}
