<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class BoxRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if((isset($this->action)) && (($this->action) == "store") ){
            $con    =   [
                            'client_id'         => 'required',
                            'name'              => 'required|min:3|unique:boxes,name',
                            'price'             => 'required',
                            'description'       => 'required',
                            'qrcode'            => 'required',
                            'barcode'           => 'required',
                        ];

            return $con; 
        }else{
            $con    =   [
                            
                            'client_id'         => 'required',
                            'name'              => 'required|min:3',
                            'price'             => 'required',
                            'description'       => 'required',
                            'qrcode'            => 'required',
                            'barcode'           => 'required',
                            
                        ];
            return $con; 
        }
    }

    public function messages()
    {
        return [
            'name.required' => 'The Box name is required',
            'name.min'      => 'The Box name must be three or more character long',
            
        ];
    }
}
