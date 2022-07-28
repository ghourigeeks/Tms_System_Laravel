<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
    protected $dates    = ['deleted_at'];

    protected $fillable = [
        'fullname',
        'username',
        'email',
        'phone_no',
        'password',
        'address',
        'region_id',
        'country_id',
        'state',
        'city',
        'profile_pic',
        'verified',
        'temp_code',
        'forgot',
        'active'
    ];

    public function getActiveAttribute($value)
    {
        return ($value == 1) ? "Active" : "Inactive";
    }

    public function getProfilePicAttribute($value)
    {
        return ( isset($value) && (file_exists( public_path('uploads/clients/'.$value) ))) 
            ? asset('/uploads/clients/'.$value)
            : asset('/uploads/no_image.png');
    }


    public function getVerifiedAttribute($value)
    {
        return ($value == 1) ? "Verified" : "Not Verified";
    }

    public function getFullnameAttribute($value)
    {
        return ucwords($value);
    }
    
    public function getSateAttribute($value)
    {
        return ucwords($value);
    }

    public function getCityAttribute($value)
    {
        return ucwords($value);
    }
}
