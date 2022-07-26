<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if((isset($this->action)) && (($this->action) == "store") ){
            $con    =   [
                            'name'                  => 'required|min:3|regex:/^([^0-9]*)$/',
                            'email'                 => 'email|unique:users,email',
                            'contact_no'            => 'required|unique:users,contact_no|digits:11|numeric',
                            'password'              => 'required|min:8',
                            'roles'                 => 'required',
                        ];

            if(!empty($this->profile_pic)){
                $con['profile_pic']     = 'required|image|mimes:jpeg,png,jpg,gif|max:2048';
            }

            return $con; 

        }else{
            // vaidate if form has profile pic
            $con    =   [
                            'name'                  => 'required|min:3|regex:/^([^0-9]*)$/',
                            'email'                 => ['email', Rule::unique('users')->ignore($this->user)], 
                            'contact_no'            => ['required','digits:11','numeric', Rule::unique('users')->ignore($this->user)],
                            'roles'                 => 'required',
                        ];
            
            if(!empty($this->profile_pic)){
                $con['profile_pic']     = 'required|image|mimes:jpeg,png,jpg,gif|max:2048';
            }
            return $con; 
        }
    }
}
    
