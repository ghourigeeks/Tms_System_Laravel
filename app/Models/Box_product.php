<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Box_product extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'box_id',
        'product_id',
        'qty',
        'active',
    ];

    public function getActiveAttribute($value)
    {
        return ($value == 1) ? "Active" : "Inactive";
    }


    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function box()
    {
        return $this->belongsTo(Box::class, 'box_id', 'id');
    }
}
