<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory,SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'question',
        'description',
        'active'
    ];

    public function getActiveAttribute($value){
        return ($value == 1) ? "Active" : "Inactive";
    }
}
