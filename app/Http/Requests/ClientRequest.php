<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if((isset($this->action)) && (($this->action) == "store") ){
            $con    =   [
                            'fullname'      => 'required|min:3|regex:/^([^0-9]*)$/',
                            'username'      => 'required|min:3|unique:clients,username',
                            'email'         => 'required|email|unique:clients,email',
                            'phone_no'      => 'required|unique:clients,contact_no|digits:11|numeric',
                            'password'      => 'required|min:3',
                            'address'       => 'required|min:3',
                            'region_id'     => 'required|numeric',
                            'country_id'    => 'required|numeric',
                            'state'         => 'required|min:3',
                            'city'          => 'required|min:3',
                        ];

            if(!empty($this->profile_pic)){
                $con['profile_pic']     = 'required|image|mimes:jpeg,png,jpg,gif|max:2048';
            }

            return $con; 
        }else{
            $con    =   [
                'fullname'      => 'required|min:3|regex:/^([^0-9]*)$/',
                'username'      => ['required', Rule::unique('clients')->ignore($this->client)],
                'email'         => ['required', 'email', Rule::unique('clients')->ignore($this->client)],
                'phone_no'      => ['required', 'digits:11','numeric', Rule::unique('clients')->ignore($this->client)],
                'password'      => 'required|min:3',
                'address'       => 'required|min:3',
                'region_id'     => 'required|numeric',
                'country_id'    => 'required|numeric',
                'state'         => 'required|min:3',
                'city'          => 'required|min:3',
            ];
           
                        
            if(!empty($this->profile_pic)){
                $con['profile_pic']     = 'required|image|mimes:jpeg,png,jpg,gif|max:2048';
            }

            return $con; 
        }
    }
}
