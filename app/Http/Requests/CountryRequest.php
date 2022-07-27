<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CountryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

      if((isset($this->action)) && (($this->action) == "store") ){
        return [
            'name' => 'required|min:3|unique:countries,name'
        ];
      }else{
        return [
            'name' => ['min:3','required', Rule::unique('countries')->ignore($this->country)],
        ];
      }
        
       
    }

    public function messages()
    {
        return [
            'name.required' => 'The country name is required',
            'name.min'      => 'The country name must be three or more character long',
            
        ];
    }
}
