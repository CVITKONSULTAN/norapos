<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VenueBookingItem extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'quantity' => 'decimal:4',
        'price' => 'decimal:4',
        'subtotal' => 'decimal:4',
    ];

    public function venueBooking()
    {
        return $this->belongsTo(VenueBooking::class);
    }

    /**
     * Auto-calculate subtotal on save
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->subtotal = $model->quantity * $model->price;
        });
    }
}
