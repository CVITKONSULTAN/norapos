<?php

namespace App\Models\Hotel;

use Illuminate\Database\Eloquent\Model;

class ShiftLog extends Model
{
    protected $fillable = [
        'status',
        'file_path',
        'reviewed_by',
        'user_id',
        'business_id',
        'total_cash',
        'total_transfer',
        'total_room',
    ];

    public function reviewed()
    {
        return $this->belongsTo(\App\User::class,"reviewed_by","id");
    }
    public function user()
    {
        return $this->belongsTo(\App\User::class,"user_id","id");
    }
    public function business()
    {
        return $this->belongsTo(\App\Business::class,"business_id","id");
    }
}
