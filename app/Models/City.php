<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class City extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'province_id',
        'lat',
        'lng',
        'active'
    ];

    public function getActiveAttribute($value)
    {
        return ($value == 1) ? "Active" : "Inactive";
    }

    public function getNameAttribute($value)
    {
        return ucwords($value);
    }

  
    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id', 'id');
    }

    public function areas($city_id)
    {
        return  Area::orderBy('city_id')
                    ->where('city_id', $city_id)
                    ->select(
                                'city_id',
                                'id as area_id',
                                'name as value',
                                // 'lat as area_lat',
                                // 'lng as area_lng'
                            )
                    ->where('active',1)
                    ->get();



    }
}
