<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FCMToken extends Model
{
    protected $fillable = [
        'token',
        'devices',
        'business_id',
        'user_id',
    ];

    function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
    function business(){
        return $this->belongsTo(Business::class,'business_id','id');
    }
}
