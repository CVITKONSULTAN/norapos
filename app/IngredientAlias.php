<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IngredientAlias extends Model
{
    protected $guarded = ['id'];

    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class);
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    /**
     * Find ingredient by alias name (exact match, case-insensitive)
     */
    public static function findByAlias($aliasName, $businessId)
    {
        $normalized = strtoupper(trim($aliasName));

        return self::where('business_id', $businessId)
            ->whereRaw('UPPER(alias_name) = ?', [$normalized])
            ->with('ingredient')
            ->first();
    }

    /**
     * Save or update an alias mapping
     */
    public static function saveAlias($aliasName, $ingredientId, $businessId)
    {
        $normalized = trim($aliasName);
        if (empty($normalized)) return null;

        return self::updateOrCreate(
            [
                'business_id' => $businessId,
                'alias_name' => $normalized,
            ],
            [
                'ingredient_id' => $ingredientId,
            ]
        );
    }
}
