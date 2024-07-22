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
       'status',
       "brand_name",
        "brand_id",
        "deposit",
        "metode_pembayaran"
    ];

    function contact(){
        return $this->belongsTo(\App\Contact::class,"contact_id","id");
    }

    function brand(){
        return $this->belongsTo(\App\Brands::class,"brand_id","id");
    }
}
