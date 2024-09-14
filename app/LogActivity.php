<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogActivity extends Model
{

    protected $fillable = [
        'actions',
        'action_reference',
        'relation_id',
        'user_id',
    ];

    function User(){
        return $this->belongsTo(User::class,'user_id','id');
    }

}
