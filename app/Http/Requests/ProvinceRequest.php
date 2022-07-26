<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ProvinceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

      if((isset($this->action)) && (($this->action) == "store") ){
        return [
            'name' => 'required|min:3|unique:provinces,name'
        ];
      }else{
        return [
            'name' => ['min:3','required', Rule::unique('provinces')->ignore($this->province)],
        ];
      }
        
       
    }

    public function messages()
    {
        return [
            'name.required' => 'Province name is required',
            'name.min'      => 'Province name must be three or more character long',
            
        ];
    }
}
