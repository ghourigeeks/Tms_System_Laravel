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
                'name' => 'required|min:3|unique:complaints,name',
            ];
          }else{
            return [
                'name' => ['min:3','required', Rule::unique('complaints')->ignore($this->complaint)]
            ];
        }
    }
}
