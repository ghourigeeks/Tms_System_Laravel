<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Leave;
use Carbon\Carbon;

class Leave extends Model
{
    protected $fillable = [
        'user_id',
        'user_email',
        'user_contact',
        'subject',
        'reason',
        'leave_start',
        'leave_end',
        'pending',
        'active',
        'created_by',
        'updated_by'
    ];

    public function getActiveAttribute($value)
    {
        return ($value == 1) ? "Active" : "Inactive";
    }

    public function getSubjectAttribute($value)
    {
        return ucwords($value);
    }

    public function getCreatedAtAttribute($value)
    {
        if($value){
            return Carbon::parse($value)->format('D - h:i A');
        }    
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function userEmail()
    {
        return $this->belongsTo(User::class, 'user_email', 'id');
    }

    public function userContact()
    {
        return $this->belongsTo(User::class, 'user_contact', 'id');
    }
    
}
