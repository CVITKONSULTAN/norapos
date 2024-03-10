<?php

namespace App\Models\itkonsultan;

use Illuminate\Database\Eloquent\Model;

class BusinessTransaction extends Model
{
    protected $fillable = [
        'status',
        'user_phones_id',
        'metadata',
        'category',
        'title'
    ];

    function user(){
        return $this->belongsTo(UserPhones::class,"user_phones_id","id");
    }
}
