<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cooldown extends Model
{
    protected $fillable = [
        'donor_id',
        'cooldown_until',
        'reason',
    ];

    protected $casts = [
        'cooldown_until' => 'datetime',
    ];

    public function donor()
    {
        return $this->belongsTo(Donor::class);
    }
}