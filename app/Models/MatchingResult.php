<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MatchingResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'donor_request_id',
        'donor_id',
        'distance_km',
        'priority_score',
        'is_eligible'
    ];

    public function request()
    {
        return $this->belongsTo(DonorRequest::class, 'donor_request_id');
    }

    public function donor()
    {
        return $this->belongsTo(Donor::class);
    }
}