<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BloodType extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'type',
        'rhesus'
    ];

    public function donors()
    {
        return $this->hasMany(Donor::class);
    }
}