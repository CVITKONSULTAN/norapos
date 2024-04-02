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

        'isAdmin',
        'adminToken',
        'log_uid',

        'business_domain_id',

    ];

    function transaction(){
        return $this->hasMany(BusinessTransaction::class,"user_phones_id","id");
    }

    function business(){
        return $this->belongsTo(BusinessDomain::class,"business_domain_id",'id');
    }
}
