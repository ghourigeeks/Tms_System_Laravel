<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'amount',
        'box_limit',
        'inventory_limit',
        'add_to_mp',
        'ibeacon',
        'barcode',
        'qrcode',
        'active',
        'created_by'
    ];

    public function getActiveAttribute($value)
    {
        return ($value == 1) ? "Active" : "Inactive";
    }

    public function getAddToMpAttribute($value)
    {
        return ($value == 1) ? "Active" : "Inactive";
    }

    public function getIbeaconAttribute($value)
    {
        return ($value == 1) ? "Active" : "Inactive";
    }

    public function getBarcodeAttribute($value)
    {
        return ($value == 1) ? "Active" : "Inactive";
    }

    public function getQrcodeAttribute($value)
    {
        return ($value == 1) ? "Active" : "Inactive";
    }

    public function getNameAttribute($value)
    {
        return ucwords($value);
    }
}
