<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Contest;

class Contest extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'contest_url',
        'start_date',
        'start_time',
        'end_time',
        'final',
        'work_from',
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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
