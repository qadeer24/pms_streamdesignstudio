<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AreaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

      if((isset($this->action)) && (($this->action) == "store") ){
        return [
            'name'        => 'required|min:3|unique:areas,name',
            'lat'         => 'required|numeric',
            'lng'         => 'required|numeric',
            'city_id'     => 'required|numeric'
        ];
      }else{
        return [
            'name'        => ['min:3','required', Rule::unique('areas')->ignore($this->city)],
            'lat'         => 'required|numeric',
            'lng'         => 'required|numeric',
            'city_id'     => 'required|numeric'
        ];
      }
        
       
    }

    public function messages()
    {
        return [
            'name.required'         => 'City name is required',
            'name.min'              => 'City name must be three or more character long',
            'lat.required'          => 'City latitude is required',
            'lng.required'          => 'City longitude is required',
            'city_id.required'      => 'Province is required',
        ];
    }
}
