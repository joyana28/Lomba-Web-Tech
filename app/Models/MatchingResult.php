<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MatchingResult extends Model
{
    protected $fillable = [
        'donor_request_id',
        'donor_id',
        'distance_km',
        'priority_score',
        'is_eligible',
        'notes',
    ];

    protected $casts = [
        'distance_km' => 'float',
        'priority_score' => 'float',
        'is_eligible' => 'boolean',
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