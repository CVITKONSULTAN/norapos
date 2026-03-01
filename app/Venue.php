<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'base_price' => 'decimal:4',
        'is_active' => 'boolean',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function bookings()
    {
        return $this->hasMany(VenueBooking::class);
    }

    /**
     * Scope: only active venues
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Dropdown helper
     */
    public static function forDropdown($business_id, $prepend_none = false)
    {
        $venues = self::where('business_id', $business_id)
            ->where('is_active', true)
            ->orderBy('name')
            ->pluck('name', 'id');

        if ($prepend_none) {
            $venues->prepend(__('lang_v1.none'), '');
        }

        return $venues;
    }
}
