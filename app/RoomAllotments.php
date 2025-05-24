<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomAllotments extends Model
{
    protected $fillable = [
        'business_id',
        // 'product_id',
        // 'brand',
        'qty_room',
        'qty_date',
        'room_category',
        'price',
        'close_out'
    ];
    protected $casts = [
        'qty_date' => 'date',
        'price' => 'integer',
        'close_out' => 'boolean'
    ];
    // protected $appends = ['formatted_qty_date'];
    // protected $hidden = ['created_at', 'updated_at'];
    // protected $dates = ['qty_date'];
    // protected $table = 'room_allotments';

    public function getFormattedQtyDateAttribute()
    {
        return $this->qty_date->format('Y-m-d');
    }
    // public function product()
    // {
    //     return $this->belongsTo(\App\Product::class, 'product_id');
    // }
    public function business()
    {
        return $this->belongsTo(\App\Business::class, 'business_id');
    }
}
