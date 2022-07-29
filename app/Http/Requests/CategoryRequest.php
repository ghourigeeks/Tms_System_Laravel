<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

      if((isset($this->action)) && (($this->action) == "store") ){
        return [
            'name'        => 'required|min:3|unique:categories,name',
        ];
      }else{
        return [
            'name'        => 'required|min:3',
        ];
      }
        
       
    }

    public function messages()
    {
        return [
            'name.required'         => 'Category name is required',
            'name.min'              => 'Category name must be three or more character long',
            
        ];
    }
}
