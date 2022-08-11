<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Ibeacon extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'client_id',
        'box_id',
        'serial_no',
        'active',
    ];

    public function getActiveAttribute($value)
    {
        return ($value == 1) ? "Active" : "Inactive";
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    public function box()
    {
        return $this->belongsTo(Box::class, 'box_id', 'id')
                ->select('id','name','price');
    }

}
