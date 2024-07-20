<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HotelReservasi extends Model
{
    protected $fillable = [
       'harga',
       'checkin',
       'checkout',
       'durasi',
       'contact_id',
       'ota',
    ];

    function contact(){
        return $this->belongsTo(\App\Contact::class,"contact_id","id");
    }
}
