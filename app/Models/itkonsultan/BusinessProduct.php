<?php

namespace App\Models\itkonsultan;

use Illuminate\Database\Eloquent\Model;

use App\Models\itkonsultan\BusinessDomain;

class BusinessProduct extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'business_id',
        'category_slug'
    ];

    function business(){
        return $this->belongsTo(BusinessDomain::class,'business_id','id');
    }
}
