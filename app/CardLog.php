<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CardLog extends Model
{

    protected $fillable = [
        "user_id",
        "token",
        "nama",
        "checkin",
        "checkout",
        "product_id",
        "contact_id",
    ];

    function contact(){
        return $this->belongsTo(\App\Contact::class,"contact_id","id")
        ->withDefault();
    }

    function user(){
        return $this->belongsTo(\App\User::class,"user_id","id")
        ->withDefault();
    }

    function product(){
        return $this->belongsTo(\App\Product::class,"product_id","id")
        ->withDefault();
    }


}
