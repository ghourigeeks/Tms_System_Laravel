<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ComplaintRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    
    public function rules()
    {
        if((isset($this->action)) && (($this->action) == "store") ){
            return [
                'response' => 'required|min:3',
            ];
          }else{
            return [
                'response' => 'min:3|required'
            ];
        }
    }
}
