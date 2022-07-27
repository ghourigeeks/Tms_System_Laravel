<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'region_id',
        'active'
    ];

    public function getActiveAttribute($value)
    {
        return ($value == 1) ? "Active" : "Inactive";
    }

    public function Region()
    {
        return $this->belongsTo(Region::class,'region_id');
    }

    public function getNameAttribute($value)
    {
        return ucwords($value);
    }
    
}
