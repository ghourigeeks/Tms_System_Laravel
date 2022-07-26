<?php

namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class People_rating extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates    = ['deleted_at'];
    protected $fillable = [
        'captain_id',
        'passenger_id',
        'rating',
        'active'
    ];

    public function getCreatedAtAttribute($value)
    {
        if($value){
            return Carbon::parse($value)->format('d-M-Y h:i:s A');
        }
        
    }

}
