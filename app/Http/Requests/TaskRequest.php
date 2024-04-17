<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
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
        return [
            'name'              => 'required|min:3|unique:projects,name',
            'description'       => 'required|min:3',
            'task_img'          => 'required',
            'project_id'        => 'required',
            'assigned_to'       => 'required',
            'deadline'          => 'required|date',
        ];
    }
}
