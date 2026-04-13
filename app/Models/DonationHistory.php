<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DonationHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'donor_id',
        'donor_request_id',
        'donation_date',
        'status'
    ];

    public function donor()
    {
        return $this->belongsTo(Donor::class);
    }

    public function request()
    {
        return $this->belongsTo(DonorRequest::class, 'donor_request_id');
    }
}