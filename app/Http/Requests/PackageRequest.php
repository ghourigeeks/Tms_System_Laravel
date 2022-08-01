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
                            'name'              => 'required|min:3|regex:/^([^0-9]*)$/|unique:packages,name',
                            'amount'            => 'required|min:0|numeric',
                            'box_limit'         => 'required|min:0|numeric',
                            'inventory_limit'   => 'required|min:0|numeric',
                        ];
            return $con; 
        }else{
            $con    =   [
                            'name'               => ['required','min:3',"regex:/^([^0-9]*)$/", Rule::unique('packages')->ignore($this->package)], 
                            'amount'             => ['required','min:0','numeric'],
                            'box_limit'          => ['required','min:0','numeric'],
                            'inventory_limit'    => ['required','min:0','numeric'],

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
