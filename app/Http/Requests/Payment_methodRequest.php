<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class Payment_methodRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if((isset($this->action)) && (($this->action) == "store") ){
            $con    =   [
                            'name'        => 'required|min:3|unique:payment_methods,name',
                            'public_key'  => 'required|min:30',
                            'private_key' => 'required|min:13'
                        ];

            return $con; 
        }else{
            $con    =   [
                            
                            'name'        => ['required','min:3'],
                            'public_key'  => ['required','min:30'],
                            'private_key' => ['required','min:13'],
                            
                        ];
            return $con; 
        }
    }

    public function messages()
    {
        return [
            'name.required' => 'The payment name is required',
            'name.min'      => 'The payment name must be three or more character long',
            
        ];
    }
}
