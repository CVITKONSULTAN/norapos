<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $fillable = [
        'tipe',
        'coordinates',
        'picture',
        'user_id',
        'business_id',
    ];

    protected $casts = [
        'coordinates' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(\App\User::class,"user_id","id");
    }
    public function business()
    {
        return $this->belongsTo(\App\Business::class,"business_id","id");
    }
}
