<?php

namespace App\Http\Requests\Clients;

use Illuminate\Foundation\Http\FormRequest;

class CreateClient extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            //
            'Name' => 'required',
            'email' => 'nullable|email|unique:clients,email',
            'phone' => 'nullable|required_without:cellphone|numeric|unique:clients,phone',
            'whatsapp' => 'nullable|numeric|unique:clients,whatsapp'
        ]; 
    }
}
