<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonationHistory extends Model
{
    protected $fillable = [
        'donor_id',
        'donor_request_id',
        'notes',
        'donated_at',
    ];

    protected $casts = [
        'donated_at' => 'datetime',
    ];

    public function donor()
    {
        return $this->belongsTo(Donor::class);
    }

    public function donorRequest()
    {
        return $this->belongsTo(DonorRequest::class);
    }
}