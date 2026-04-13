<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Location extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'latitude',
        'longitude',
        'address'
    ];

    public function donors()
    {
        return $this->hasMany(Donor::class);
    }

    public function requests()
    {
        return $this->hasMany(DonorRequest::class);
    }
}