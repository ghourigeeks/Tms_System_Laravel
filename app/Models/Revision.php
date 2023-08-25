<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Revision;

class Revision extends Model
{
    protected $fillable = [
        'user_id',
        'order_id',
        'revisions',
        'start_date',
        'start_time',
        'end_time',
        'complete',
        'work_from',
        'active',
        'created_by',
        'updated_by'
    ];

    public function getActiveAttribute($value)
    {
        return ($value == 1) ? "Active" : "Inactive";
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
}
