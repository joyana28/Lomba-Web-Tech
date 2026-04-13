<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DonorRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_by',
        'blood_type_id',
        'location_id',
        'quantity',
        'urgency',
        'deadline',
        'status'
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function bloodType()
    {
        return $this->belongsTo(BloodType::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function matchingResults()
    {
        return $this->hasMany(MatchingResult::class);
    }

    public function histories()
    {
        return $this->hasMany(DonationHistory::class);
    }
}