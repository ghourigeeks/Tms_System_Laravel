<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PackageRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if((isset($this->action)) && (($this->action) == "store") ){
            $con    =   [
                            'name'              => 'required|min:3|unique:payment_methods,name',
                            'amount'            => 'required|numeric',
                            'box_limit'         => 'required|digits:1|numeric',
                            'inventory_limit'   => 'required|digits:1|numeric',
                        ];
            return $con; 
        }else{
            $con    =   [
                            'name'               => ['required'], 
                            'amount'             => ['required','numeric'],
                            'box_limit'          => ['required','digits:1','numeric'],
                            'inventory_limit'    => ['required','digits:1','numeric'],

                        ];
            return $con; 
        }
    }

    public function messages()
    {
        return [
            'name.required' => 'The package name is required',
            'name.min'      => 'The package name must be three or more character long',
            
        ];
    }
}
