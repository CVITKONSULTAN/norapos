<?php

namespace Modules\TastypointsAPI\Entities;

use Illuminate\Database\Eloquent\Model;

class WalletUserLogTest extends Model
{
    protected $fillable = [
        "user_id",
        "type",
        "response",
    ];
}
