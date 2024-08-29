<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class CreateUser extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            //
            'name' => 'required',
            'photo' => 'nullable|image',
            'email' => 'nullable|email|unique:users,email',
            'phone' => 'required|numeric|unique:users,phone',
            'username' => 'nullable|unique:users,username'
        ];
    }
}
