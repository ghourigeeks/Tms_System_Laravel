<?php

namespace App\Models;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class History extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates    = ['deleted_at'];
    protected $fillable = [
        'people_id',
        'type',
        'schedule_id',
        'booking_id',
        'detail',
        'status_id',
        'active'
    ];

    public function getCreatedAtAttribute($value)
    {
        if($value){
            return Carbon::parse($value)->format('d-M-Y h:i:s A');
        }
        
    }

    public function getTypeAttribute($value)
    {
        return ($value == 1) ? "Captain" : "Passenger";
    }
}
