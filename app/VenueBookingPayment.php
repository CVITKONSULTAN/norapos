<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VenueBookingPayment extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'amount' => 'decimal:4',
        'paid_at' => 'date',
    ];

    public function venueBooking()
    {
        return $this->belongsTo(VenueBooking::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getMethodLabelAttribute()
    {
        $labels = [
            'cash' => 'Cash',
            'transfer' => 'Transfer',
            'card' => 'Kartu',
            'other' => 'Lainnya',
        ];

        return $labels[$this->method] ?? $this->method;
    }
}
