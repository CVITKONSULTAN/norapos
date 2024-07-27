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
    ];


}
