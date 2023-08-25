<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

      if((isset($this->action)) && (($this->action) == "store") ){
        return [
            'name'       => 'required|min:3|unique:clients,name',
        ];
      }else{
        return [
            'name'       => ['min:3','required'],
        ];
      }   
    }

    public function messages()
    {
        return [
            'name.required'          => 'The Client name is required',
            'name.min'               => 'The Client name must be three or more character long',
        ];
    }
}
