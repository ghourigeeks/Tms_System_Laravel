<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Schedule extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates    = ['deleted_at'];
    protected $fillable = [
        'captain_id',
        'vehicle_id',

        'pickup_city_id',
        'pickup_lat',
        'pickup_lng',
        'pickup_address',

        'dropoff_city_id',
        'dropoff_lat',
        'dropoff_lng',
        'dropoff_address',

        'schedule_date',
        'schedule_time',

        'vacant_seat',
        'fare',

        'cancel_reason_id',
        'cancel_reason',
        
        'status_id',
        
        'show_contact',
        
        'start_time',
        'end_time',
        
        'start_date',
        'end_date',
        
        'active'
    ];

    public function getPickupTimeAttribute($value)
    {
        if($value){
            return Carbon::parse($value)->format('h:i A');
        }
    }

    public function getDropoffTimeAttribute($value)
    {
        if($value){
            return Carbon::parse($value)->format('h:i A');
        }
    }
    
    public function getCreatedAtAttribute($value)
    {
        if($value){
            return Carbon::parse($value)->format('d-M-Y h:i:s A');
        }
        
    }

    public function getActiveAttribute($value)
    {
        return ($value == 1) ? "Active" : "Inactive";
    }

}
