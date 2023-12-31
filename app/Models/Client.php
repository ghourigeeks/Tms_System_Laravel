<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Client;

class Client extends Model
{
    protected $fillable = [
        'name',
        'active',
        'created_by',
        'updated_by'
    ];

    public function getActiveAttribute($value)
    {
        return ($value == 1) ? "Active" : "Inactive";
    }

    public function getNameAttribute($value)
    {
        return ucwords($value);
    }

    
}
