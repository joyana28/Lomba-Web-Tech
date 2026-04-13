<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cooldown extends Model
{
    use HasFactory;

    protected $fillable = [
        'donor_id',
        'last_donation_date',
        'next_available_date',
        'is_active'
    ];

    public function donor()
    {
        return $this->belongsTo(Donor::class);
    }
}