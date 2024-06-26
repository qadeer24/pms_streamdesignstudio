<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class MessageRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            
            'sender_name' => 'required',
            'message'     => 'required',
            'sender_id'   => 'required|numeric',
            'receiver_id' => 'required|numeric'
        ];
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
            'message.required'     => 'Message is required',
            'sender_name.required' => 'Sender name  is required',
            'sender_id.required'   => 'Sender Id is required',
            'receiver_id.required' => 'Receiver Id is required'
        ];
    }
}
