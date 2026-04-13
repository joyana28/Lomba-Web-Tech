<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function donor()
    {
        return $this->hasOne(Donor::class);
    }

    public function donorRequests()
    {
        return $this->hasMany(DonorRequest::class, 'created_by');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}