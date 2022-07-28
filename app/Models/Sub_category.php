<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sub_category extends Model
{
    use HasFactory;
    // protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'cat_id'
    ];


    public function getNameAttribute($value)
    {
        return ucwords($value);
    }
}
