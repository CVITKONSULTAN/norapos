<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class VenueBooking extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'price_per_pax' => 'decimal:4',
        'total_amount' => 'decimal:4',
        'dp_amount' => 'decimal:4',
        'remaining_amount' => 'decimal:4',
        'event_date' => 'date',
    ];

    /**
     * Boot: auto-generate booking_ref
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->booking_ref)) {
                $model->booking_ref = self::generateBookingRef();
            }
        });
    }

    /**
     * Generate unique booking reference: VB-YYYYMMDD-XXXX
     */
    public static function generateBookingRef()
    {
        $prefix = 'VB-' . date('Ymd') . '-';
        $lastBooking = self::where('booking_ref', 'like', $prefix . '%')
            ->orderBy('booking_ref', 'desc')
            ->first();

        if ($lastBooking) {
            $lastNumber = intval(substr($lastBooking->booking_ref, -4));
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        return $prefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }

    // ========== Relationships ==========

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function items()
    {
        return $this->hasMany(VenueBookingItem::class);
    }

    public function payments()
    {
        return $this->hasMany(VenueBookingPayment::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // ========== Accessors ==========

    public function getStatusLabelAttribute()
    {
        $labels = [
            'pending' => '<span class="label label-warning">Pending</span>',
            'confirmed' => '<span class="label label-info">Confirmed</span>',
            'in_progress' => '<span class="label label-primary">In Progress</span>',
            'completed' => '<span class="label label-success">Completed</span>',
            'cancelled' => '<span class="label label-danger">Cancelled</span>',
        ];

        return $labels[$this->status] ?? '<span class="label label-default">' . $this->status . '</span>';
    }

    public function getPricingTypeLabelAttribute()
    {
        $labels = [
            'per_pax' => 'Per Pax',
            'paket' => 'Paket',
            'custom' => 'Custom',
        ];

        return $labels[$this->pricing_type] ?? $this->pricing_type;
    }

    // ========== Methods ==========

    /**
     * Recalculate total from items
     */
    public function recalculateTotal()
    {
        $itemsTotal = $this->items()->sum('subtotal');
        $paidTotal = $this->payments()->sum('amount');

        $this->total_amount = $itemsTotal;
        $this->dp_amount = $paidTotal;
        $this->remaining_amount = $itemsTotal - $paidTotal;
        $this->save();
    }

    // ========== Scopes ==========

    public function scopeUpcoming($query)
    {
        return $query->where('event_date', '>=', Carbon::today())
            ->whereNotIn('status', ['cancelled', 'completed'])
            ->orderBy('event_date', 'asc');
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
