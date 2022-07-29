<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_image extends Model
{
    
    public $timestamps = false;
    protected $fillable = [
        'product_id',
        'pic'
    ];

    public function getPicAttribute($value)
    {
        return ( isset($value) && (file_exists( public_path('uploads/products/'.$value) ))) 
            ? asset('uploads/products/'.$value)
            : asset('uploads/no_image.png');
    }



}
