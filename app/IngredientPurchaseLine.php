<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IngredientPurchaseLine extends Model
{
    protected $guarded = ['id'];

    public function purchase()
    {
        return $this->belongsTo(IngredientPurchase::class, 'ingredient_purchase_id');
    }

    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class);
    }
}
