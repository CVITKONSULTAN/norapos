<?php

namespace Modules\TastypointsAPI\Entities;

use Illuminate\Database\Eloquent\Model;

class WalletUserTest extends Model
{
    protected $fillable = [
        "user_id",
        "balance",
        "stripe_key",
    ];
}
