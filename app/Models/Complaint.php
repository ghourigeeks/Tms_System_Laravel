<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Client;
use Carbon\Carbon;

class Complaint extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'client_id',
        'subject',
        'description',
        'complaint_id',
        'res'
    ];

    public function getActiveAttribute($value)
    {
        return ($value == 1) ? "Active" : "Inactive";
    }
    public function getCreatedAtAttribute($value)
    {
        if($value){
            return Carbon::parse($value)->format('D - h:i A');
        }    
    }
    public function client()
    {
        $clients = $this->belongsTo(Client::class,'client_id','id');
        return $clients;
    }
}
