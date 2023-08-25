<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'concepts',
        'start_date',
        'start_time',
        'end_time',
        'category_id',
        'client_id',
        'logo_type',
        'payment',
        'total_payment',
        'complete',
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
    
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }
    
}
