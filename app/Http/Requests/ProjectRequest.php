<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if((isset($this->action)) && (($this->action) == "store") ){
            return [
                'name'              => 'required|min:3|unique:projects,name',
                'price'             => 'required|min:3',
                'project_category'  => 'required',
                'tech_stack'        => 'required',
                'db_name'           => 'required|min:3',
                'deadline'          => 'required|date',
            ];
          }else{
            return [
                'name'              => 'required|min:3',
                'price'             => 'required|min:3',
                'project_category'  => 'required',
                'tech_stack'        => 'required',
                'db_name'           => 'required|min:3',
            ];
        }
    }
}
