<?php

namespace App\Http\Requests\Clients;

use Illuminate\Foundation\Http\FormRequest;

class EditClient extends FormRequest
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
            'email' => 'nullable|email|unique:clients,email,'.$this->id,
            'phone' => 'nullable|required_without:cellphone|numeric|unique:clients,phone,'.$this->id,
            'whatsapp' => 'nullable|numeric|unique:clients,whatsapp,'.$this->id
        ];
    } 
}
