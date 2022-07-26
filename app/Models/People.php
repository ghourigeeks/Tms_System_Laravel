<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class People extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
    protected $dates    = ['deleted_at'];

    protected $fillable = [
        'type',
        'role',
        'cnic',
        'fname',
        'password',
        'contact_no',
        'verified',
        'active',
        'forgot',
        'otp',
        'temp_code'
    ];

    public function getActiveAttribute($value)
    {
        return ($value == 1) ? "Active" : "Inactive";
    }

    public function getTypeAttribute($value)
    {
        return ($value == 1) ? "Captain" : "Passenger";
    }

    public function getRoleAttribute($value)
    {
        return ($value == 1) ? "Captain" : "Passenger";
    }

    public function getFnameAttribute($value)
    {
        return ucwords($value);
    }
}
