<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VenueBookingIngredient extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'qty' => 'decimal:4',
    ];

    public function booking()
    {
        return $this->belongsTo(VenueBooking::class, 'venue_booking_id');
    }

    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class, 'ingredient_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
