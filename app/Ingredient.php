<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    protected $guarded = ['id'];

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function stocks()
    {
        return $this->hasMany(IngredientStock::class);
    }

    public function stockLogs()
    {
        return $this->hasMany(IngredientStockLog::class);
    }

    public function recipes()
    {
        return $this->hasMany(ProductRecipe::class);
    }

    public function aliases()
    {
        return $this->hasMany(IngredientAlias::class);
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public static function forDropdown($business_id)
    {
        return self::where('business_id', $business_id)
            ->where('is_active', true)
            ->orderBy('name')
            ->pluck('name', 'id');
    }
}
