<?php

namespace App\Models\itkonsultan;

use Illuminate\Database\Eloquent\Model;

class UserPhones extends Model
{
    protected $fillable = [
        "fcmToken",
        "uid",
        "brand",
        "osVersion",
        "email",
        "nohp",
        "password",
        "deleted_at",

        'name',
        'ktp',
        'provinsi',
        'kota_kab',
        'kecamatan',
        'desa',
        'alamat',

    ];

    function transaction(){
        return $this->hasMany(BusinessTransaction::class,"user_phones_id","id");
    }
}
