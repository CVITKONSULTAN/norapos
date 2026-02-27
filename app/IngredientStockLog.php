<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IngredientStockLog extends Model
{
    protected $guarded = ['id'];

    public $timestamps = false;

    protected $dates = ['created_at'];

    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function location()
    {
        return $this->belongsTo(BusinessLocation::class, 'location_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
