<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'blood_type_id',
        'location_id',
        'phone',
        'last_donation_date',
        'is_available'
    ];

    protected $casts = [
        'last_donation_date' => 'date',
        'is_available' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bloodType()
    {
        return $this->belongsTo(BloodType::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function histories()
    {
        return $this->hasMany(DonationHistory::class);
    }

    public function cooldown()
    {
        return $this->hasOne(Cooldown::class);
    }

    public function matchingResults()
    {
        return $this->hasMany(MatchingResult::class);
    }
}