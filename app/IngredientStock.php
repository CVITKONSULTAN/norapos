<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IngredientStock extends Model
{
    protected $guarded = ['id'];

    public $timestamps = false;

    protected $dates = ['updated_at'];

    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class);
    }

    public function location()
    {
        return $this->belongsTo(BusinessLocation::class, 'location_id');
    }
}
