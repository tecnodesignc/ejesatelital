<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserApiRequest extends FormRequest
{
    public function rules()
    {
        return [
            'email' => "required|email|unique:users,email,{$this->id}",
            'first_name' => 'required',
            'last_name' => 'required',
            'password' => 'confirmed',
        ];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [];
    }
}
