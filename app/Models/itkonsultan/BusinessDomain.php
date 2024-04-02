<?php

namespace App\Models\itkonsultan;

use Illuminate\Database\Eloquent\Model;

class BusinessDomain extends Model
{
    protected $fillable = [
        'business_name',
        'domain',
        'details',
        'expired_at'
    ];

    function product(){
        return $this->hasMany(BusinessDomain::class,'business_id','id');
    }

    function userphone(){
        return $this->hasMany(UserPhones::class,'business_domain_id','id');
    }

}
