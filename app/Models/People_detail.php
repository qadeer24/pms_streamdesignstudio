<?php

namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class People_detail extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates    = ['deleted_at'];
    protected $fillable = [
        'people_id',
        'email',
        'cnic',
        'address',
        'license_no',
        'age',
        'expire_date',
        'vehicle_no',
        'manufacturer',
        'modal',
        'color',
        'seat',
        'tax_pic',
        'profile_pic',
        'active'
    ];

   
    public function getCreatedAtAttribute($value)
    {
        if($value){
            return Carbon::parse($value)->format('d-M-Y h:i:s A');
        }
        
    }

}
