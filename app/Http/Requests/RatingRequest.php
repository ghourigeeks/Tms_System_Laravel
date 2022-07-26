<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class RatingRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

      if((isset($this->action)) && (($this->action) == "store") ){
        return [
            'name' => 'required|min:3|unique:ratings,name'
        ];
      }else{
        return [
            'name' => ['min:3','required', Rule::unique('ratings')->ignore($this->rating)],
        ];
      }
        
       
    }

    public function messages()
    {
        return [
            'name.required' => 'Rating name is required',
            'name.min'      => 'Rating name must be three or more character long',
            
        ];
    }
}
