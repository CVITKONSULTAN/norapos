<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IngredientPurchase extends Model
{
    protected $guarded = ['id'];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function location()
    {
        return $this->belongsTo(BusinessLocation::class, 'location_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }

    public function lines()
    {
        return $this->hasMany(IngredientPurchaseLine::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
