<?php

namespace App\Models\Ciptakarya;

use Illuminate\Database\Eloquent\Model;
use App\User;

class PbgTracking extends Model
{
     protected $table = 'pbg_trackings';

    protected $fillable = [
        'pengajuan_id',
        'user_id',
        'role',
        'catatan',
        'status',
        'verified_at'
    ];

    protected $casts = [
        'verified_at' => 'datetime',
    ];

    // ============================
    //   RELATION
    // ============================

    public function pengajuan()
    {
        return $this->belongsTo(\App\Models\CiptaKarya\PengajuanPBG::class, 'pengajuan_id');
    }

    public function user()
    {
        return $this->belongsTo( User::class, 'user_id');
    }

    // ============================
    //   HELPERS / SCOPES
    // ============================

    public function scopeRole($q, $role)
    {
        return $q->where('role', $role);
    }

    public function isApproved()
    {
        return $this->status === 'approved';
    }

    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }
}
