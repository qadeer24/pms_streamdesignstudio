<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Province extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
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

    public function cities($province_id)
    {
         
        $cities         = City::where('province_id', $province_id)
                            ->select(
                                    'province_id',
                                    'id as city_id',
                                    'name as city_name',
                                    // 'lat as city_lat',
                                    // 'lng as city_lng'
                                )
                            ->where('active',1)
                            ->get();

        $records        = array();
        $all_records    = array();


        foreach ($cities as $key => $city) {
            $records      = (object) array(
                "city_id"       => ((isset($city->city_id)) ? $city->city_id : "" ),
                "city_name"     => ((isset($city->city_name)) ? $city->city_name : "" ),
                "areas"         => $city->areas($city->city_id)
                
            );

            array_push($all_records, $records);
        }

        return $all_records;




    }
    
}
