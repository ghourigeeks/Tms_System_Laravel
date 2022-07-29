<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class IbeaconsRequest extends FormRequest
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
                            'serial_no'         => 'required|min:3',
                        ];

            return $con; 
        }else{
            $con    =   [
                            
                            'client_id'         => 'required',
                            'serial_no'         => 'required|min:3',
                            
                        ];
            return $con; 
        }
    }

    public function messages()
    {
        return [
            'client_id.required' => 'The Client ID is required',
            'serial_no.required' => 'The Serial no is required',
            
        ];
    }
}
