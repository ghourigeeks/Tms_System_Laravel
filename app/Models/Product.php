<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'client_id',
        'name',
        'price',
        'color',
        'qty',
        'description',
        'category_id',
        'sub_category_id',
        'qrcode',
        'barcode',
        'lat',
        'lng',
        'qty_to_mp',
        'added_to_mp',
        'active',
    ];

    public function getActiveAttribute($value)
    {
        return ($value == 1) ? "Active" : "Inactive";
    }


    public function getAddedToMpAttribute($value)
    {
        return ($value == 1) ? "Yes" : "No";
    }


    public function getNameAttribute($value)
    {
        return ucwords($value);
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function subCategory()
    {
        return $this->belongsTo(Sub_category::class, 'sub_category_id', 'id');
    }

    public function productImages()
    {
        return $this->hasMany(Product_image::class,'product_id','id');
    }

   





}
