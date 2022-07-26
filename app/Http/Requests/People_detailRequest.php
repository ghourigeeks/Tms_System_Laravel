<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class People_detailRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if((isset($this->action)) && (($this->action) == "store") ){
            $con    =   [
                            'fname'                 => 'required|min:3|regex:/^([^0-9]*)$/',
                            'contact_no'            => 'required|unique:people,contact_no|digits:11|numeric',
                            // 'cnic'                  => 'required|unique:people,cnic|digits:13|numeric',
                            // 'email'                 => 'email|unique:people,email',
                            'password'              => 'required|min:8'
                        ];

            if(!empty($this->profile_pic)){
                $con['profile_pic']     = 'required|image|mimes:jpeg,png,jpg,gif|max:2048';
            }

            return $con; 
        }else{
            $con    =   [
                            'fname'                 => 'required|min:3|regex:/^([^0-9]*)$/',
                            'contact_no'            => ['digits:11','numeric','required', Rule::unique('people')->ignore($this->people)],
                            // 'cnic'                  => ['digits:13','numeric','required', Rule::unique('people')->ignore($this->people)], 
                            // 'email'                 => ['email', Rule::unique('people')->ignore($this->people)], 
                            
                        ];
                        
            if(!empty($this->profile_pic)){
                $con['profile_pic']     = 'required|image|mimes:jpeg,png,jpg,gif|max:2048';
            }

            return $con; 
        }
    }
}
