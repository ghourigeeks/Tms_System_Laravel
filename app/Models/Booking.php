<?php

namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates    = ['deleted_at'];
    protected $fillable = [
        'passenger_id',
        'schedule_id',
        'book_seat',
        'arrangment',
        'cancel_reason_id',
        'cancel_reason',
        'cancel',
        'status_id',
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

}
