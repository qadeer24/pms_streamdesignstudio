<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
class MainRequest extends FormRequest
{
   
    public function rules()
    {
        if((isset($this->action)) && (($this->action) == "register") ){  // done
            $con    =   [
                            'fname'         => 'required|min:3|regex:/^([^0-9]*)$/',
                            'email'         => 'email|unique:people,email,NULL,id,verified,1',
                            'cnic'          => 'required|digits:13|regex:/^[0-9]+$/|unique:people,cnic',
                            'password'      => 'required|min:8',
                            'contact_no'    => 'required|digits:11|numeric|unique:people,contact_no,NULL,id,verified,1'
                        ];

            return $con; 

        }else if((isset($this->action)) && (($this->action) == "login") ){
            $con    =   [ 
                            'contact_no'    => 'required|digits:11|numeric|exists:people,contact_no',
                            'password'      => 'required|min:8',
                        ];
            return $con; 
        }else if((isset($this->action)) && (($this->action) == "store_details") ){
            $con    =   [
                            'people_id'               => 'required|numeric|exists:people,id',
                            'cnic'                    => 'required|digits:13|numeric|exists:people,cnic',
                            'address'                 => 'required|min:3',
                            'license_no'              => 'required|min:3',
                            'age'                     => 'required|numeric',
                            'make'                    => 'required',
                            'modal'                   => 'required',
                            'car_year'                => 'required|numeric',
                            'color'                   => 'required',
                            'seat'                    => 'required|numeric',
                            'dob'                     => 'required|date',
                            'expire_date'             => 'required|date|after:dob',
                            'vehicle_registration'    => 'required',
                            'tax_pic'                 => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
                            
                        ];

            
            return $con; 
        }else if((isset($this->action)) && (($this->action) == "verify_otp") ){
            $con    =   [
                            'otp'           => 'required|digits:4|numeric',
                            'temp_code'     => 'required|numeric'
                        ];
            return $con; 
        }else if((isset($this->action)) && (($this->action) == "forgot") ){
            $con    =   [
                            'contact_no'    => 'required|digits:11|numeric|exists:people,contact_no'
                        ];
            return $con; 
        }else if((isset($this->action)) && (($this->action) == "forgot_otp") ){
            $con    =   [
                            'otp'           => 'required|digits:4|numeric',
                            'temp_code'     => 'required|digits:10|numeric',
                        ];
            return $con; 
        }else if((isset($this->action)) && (($this->action) == "toggle_role") ){
            $con    =   [
                            'people_id'     => 'required|numeric|exists:people,id',
                            'role'          => 'required',
                        ];
            return $con; 
        }else if((isset($this->action)) && (($this->action) == "update_password") ){
            $con    =   [
                            'temp_code'     => 'required|digits:10|numeric|exists:people,temp_code',
                            'password'      => 'required|min:8',
                        ];
            return $con; 
        }else if((isset($this->action)) && (($this->action) == "fetch_ride_history") ){
            $con    =   [
                            'people_id'     => 'required|numeric|exists:people,id',
                            'role'          => 'required',
                        ];
            return $con; 
        }else if((isset($this->action)) && (($this->action) == "store_schedule") ){
            $con    =   [
                            'people_id'         => 'required|numeric|min:1|exists:people,id',
                            'vehicle_id'        => 'required|numeric|min:1|exists:people_vehicles,id',

                            'pickup_city_id'    => 'required|numeric|min:1|exists:cities,id',
                            'pickup_area_id'    => 'required|numeric|min:1|exists:areas,id',
                            // 'pickup_lat'        => 'required|numeric',
                            // 'pickup_lng'        => 'required|numeric',
                            'pickup_address'    => 'required|min:3',

                            'dropoff_city_id'   => 'required|numeric|exists:cities,id',
                            'dropoff_area_id'   => 'required|numeric|min:1|exists:areas,id',
                            // 'dropoff_lat'       => 'required|numeric',
                            // 'dropoff_lng'       => 'required|numeric',
                            'dropoff_address'   => 'required|min:3',

                            'schedule_date'     => "required|date|after_or_equal:".date('Y-m-d'),
                            'schedule_time'     => 'required|date_format:H:i',

                            'vacant_seat'       => 'required|numeric|min:1',
                            'fare'              => 'required|numeric|min:1',

                            'show_contact'      => 'required',
                        ];
            return $con; 
        }else if((isset($this->action)) && (($this->action) == "cancel_schedule") ){
            $con    =   [
                            'people_id'         => 'required|numeric|min:1|exists:people,id',
                            'schedule_id'       => 'required|numeric|min:1|exists:schedules,id',
                        ];
            return $con; 
        }else if((isset($this->action)) && (($this->action) == "store_booking") ){
            $con    =   [
                            'people_id'         => 'required|numeric|min:1|exists:people,id',
                            'schedule_id'       => 'required|numeric|min:1|exists:schedules,id',
                            'book_seat'         => 'required|numeric|min:1',
                            'arrangment'        => 'min:3',
                        ];
            return $con; 
        }else if((isset($this->action)) && (($this->action) == "cancel_booking") ){
            $con    =   [
                            'people_id'         => 'required|numeric|min:1|exists:people,id',
                            'booking_id'        => 'required|numeric|min:1|exists:bookings,id',
                        ];
            return $con; 
        }else if((isset($this->action)) && (($this->action) == "mark_booking_complete") ){
            $con    =   [
                            'people_id'         => 'required|numeric|min:1|exists:people,id',
                            'booking_id'        => 'required|numeric|min:1|exists:bookings,id',
                        ];
            return $con; 
        }else if((isset($this->action)) && (($this->action) == "fetch_schedules") ){
            $con    =   [
                            'people_id'         => 'required|numeric|min:1|exists:people,id'
                        ];
            return $con; 
        }else if((isset($this->action)) && (($this->action) == "fetch_bookings") ){
            $con    =   [
                            'people_id'         => 'required|numeric|min:1|exists:people,id'
                        ];
            return $con; 
        }else if((isset($this->action)) && (($this->action) == "fetch_schedule_by_people") ){
            $con    =   [
                            'people_id'         => 'required|numeric|min:1|exists:people,id'
                        ];
            return $con; 
        }else if((isset($this->action)) && (($this->action) == "fetch_schedule_by_city") ){
            $con    =   [
                            'pickup_city_id'    => 'required|numeric|min:1|exists:cities,id',
                            'dropoff_city_id'   => 'required|numeric|exists:cities,id'
                        ];
            return $con; 
        }else if((isset($this->action)) && (($this->action) == "fetch_schedule_by_date") ){
            $con    =   [
                            
                            'pickup_city_id'    => 'required|numeric|min:1|exists:cities,id',
                            'dropoff_city_id'   => 'required|numeric|exists:cities,id',
                            'schedule_date'     => 'required|date'
                        ];
            return $con; 
        }else if((isset($this->action)) && (($this->action) == "fetch_schedule_by_time") ){
            $con    =   [
                            'pickup_city_id'    => 'required|numeric|min:1|exists:cities,id',
                            'dropoff_city_id'   => 'required|numeric|exists:cities,id',
                            'start_time'        => 'required|date_format:H',
                            'end_time'          => 'required|date_format:H|after_or_equal:start_time',
                            'start_date'        => 'required|date_format:Y-m-d',
                            'end_date'          => 'required|date_format:Y-m-d|after_or_equal:start_date',
                        ];
            return $con; 
        }else if((isset($this->action)) && (($this->action) == "store_ratings") ){
            $con    =   [
                            'people_id'                 => 'required|numeric|min:1|exists:people,id',
                            'schedule_id'               => 'required|numeric|min:1|exists:schedules,id',
                            "rating_stars"              => "required|array|min:1",
                            "rating_stars.*"            => "required|numeric|min:0",
                            // "cap_ratings"               => "required",
                            // 'cap_ratings.*.rating_id'   => 'required',
                            // 'cap_ratings.*.rating_star' => 'required',

                        ];
            return $con; 
        }else if((isset($this->action)) && (($this->action) == "fetch_ratings") ){
            $con    =   [
                            // validation
                        ];
            return $con; 
        }else if((isset($this->action)) && (($this->action) == "update_profile") ){
            $con    =   [ 
                            'contact_no'    => 'required|digits:11|numeric|exists:people,contact_no',
                            'fname'         => 'required',
                            // 'email'         => ['required', 'email', Rule::unique('people_details')->ignore($this->people)],
                            'email'         => 'required|email:rfc,dns',
                        //   'profile_pic'   => 'required',
                        ];

                        
            if(!empty($this->profile_pic)){
                $con['profile_pic']     = 'required|image|mimes:jpeg,png,jpg,gif|max:2048';
            }
            return $con; 
        }else if((isset($this->action)) && (($this->action) == "store_people_vehicle") ){
            $con    =   [
                            'people_id'             => 'required|numeric|exists:people_details,people_id',
                            'vehicle_registration'  => 'required',
                            'make'                  => 'required',
                            'modal'                 => 'required',
                            'car_year'              => 'required',
                            'color'                 => 'required',
                            'seat'                  => 'required|numeric',
                            'tax_pic'               => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
                        ];

            
            return $con; 
        }else if((isset($this->action)) && (($this->action) == "update_people_vehicle") ){
            $con    =   [ 
                            'vehicle_id'            => 'required|numeric|exists:people_vehicles,id',
                            'vehicle_registration'  => 'required',
                            'make'                  => 'required',
                            'modal'                 => 'required',
                            'car_year'              => 'required',
                            'color'                 => 'required',
                            'seat'                  => 'required|numeric',
                        ];

            if(!empty($this->tax_pic)){
                $con['tax_pic']     = 'required|image|mimes:jpeg,png,jpg,gif|max:2048';
            }
            return $con; 
        }else if((isset($this->action)) && (($this->action) == "fetch_people_vehicle") ){
            $con    =   [
                            'people_id'         => 'required|numeric|exists:people,id'
                        ];
            return $con; 
        }else if((isset($this->action)) && (($this->action) == "logout") ){
            $con    =   [
                            'people_id'         => 'required|numeric'
                        ];
            return $con; 
        // }else if((isset($this->action)) && (($this->action) == "add_vehicle") ){
        //     $con    =   [
        //                     'contact_no'            => 'required',
        //                     'vehicle_registration'  => 'required',
        //                     'make'                  => 'required',
        //                     'modal'                 => 'required',
        //                     'color'                 => 'required',
        //                     'seat'                  => 'required|numeric',
        //                     'cnic'                  => 'required|digits:13|numeric|unique:people,cnic',
        //                     'year'                  => 'required',
        //                     'tax_pic'               => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        //                 ];
        //     return $con; 
        // }
        }else{
            return  ['action' => 'required|min:3|regex:/^([^0-9]*)$/'];
        }
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status'    => "failed",
            'msg'       => 'Validation errors',
            'data'      => $validator->errors()->all(),
        ]));
    }

    public function messages()
    {
        return [
            'fname.required'        => 'Full name is required',
            'fname.min'             => 'Full name must be 3 character long.',
            'fname.regex'           => 'Full name must not have special characters.',

            'contact_no.required'   => 'Contact number is required.',
            'contact_no.numeric'    => 'Contact number must be numeric.',
            'contact_no.digits'     => 'Contact number must have 11 digits.',
            'contact_no.unique'     => 'Contact number has already been taken.',

            'password.required'     => 'Password field is required.',
            'password.min'          => 'Password must be 8 character long.',
            'role.required'         => 'Role is required use value i.e. Captain, Passenger.',

            
            'temp_code.exists'      => 'User not found.',
            'people_id.exists'      => 'User not found.',
            'schedule_id.exists'    => 'Schedule not found.',
            'vehicle_id.exists'     => 'Vehicle not found.',
            'pickup_city_id.exists' => 'Pickup city not found.',
            'pickup_area_id.exists' => 'Pickup area not found.',
            'dropoff_city_id.exists' => 'Dropoff city not found.',
            'dropoff_area_id.exists' => 'Dropoff area not found.'
            

            
        ];
    }
}
    
