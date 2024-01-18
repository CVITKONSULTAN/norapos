<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = [
        "title",
        "description",
        "default_image",
        "language",
        "type",
        "published_at",
        'user_id',
        'business_id',
    ];

    public function user()
    {
        return $this->belongsTo(\App\User::class,"user_id","id");
    }
    public function business()
    {
        return $this->belongsTo(\App\Business::class,"business_id","id");
    }
}
