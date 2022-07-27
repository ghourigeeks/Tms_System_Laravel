<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class RegionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

      if((isset($this->action)) && (($this->action) == "store") ){
        return [
            'name' => 'required|min:3|unique:regions,name'
        ];
      }else{
        return [
            'name' => ['min:3','required', Rule::unique('regions')->ignore($this->region)],
        ];
      }
        
       
    }

    public function messages()
    {
        return [
            'name.required' => 'The region name is required',
            'name.min'      => 'The region name must be three or more character long',
            
        ];
    }
}
