<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

// use App\Models\Client;
class MainRequest extends FormRequest
{
   
    public function rules()
    {
        if((isset($this->action))){
            switch($this->action){

                case "signIn":
                    return [
                        'email'         => 'required|email',
                        'password'      => 'required|min:8',
                    ];
                break;

                case "signUp":
                    return [
                        'fullname'       => 'required|min:3|regex:/^([^0-9]*)$/',
                        'username'       => 'required|min:3|unique:clients,username',
                        'email'          => 'required|email|unique:clients,email',
                        'password'       => 'required|min:8',
                    ];
                break;

                case "forgot":
                    return ['email'      => 'required|email' ];
                break;

                case "resetPassword":
                    return  [
                        'temp_code'     => 'required|digits:10|numeric',
                        'password'      => 'required|min:8',
                    ];
                break;

                case "updateProfile":

                    $con    =   [ 
                        'client_id'      => 'required|numeric',
                        'fullname'       => 'required|min:3|regex:/^([^0-9]*)$/',
                        'username'       => ['required', Rule::unique('clients')->ignore($this->client_id)],
                        'email'          => ['required','email', Rule::unique('clients')->ignore($this->client_id)],
                        'phone_no'       => ['required', 'digits:11','numeric', Rule::unique('clients')->ignore($this->client_id)],
                        'address'        => 'required|min:3',
                        'region_id'      => 'required|numeric',
                        'country_id'     => 'required|numeric',
                        'state'          => 'required|min:3',
                        'city'           => 'required|min:3',
                    ];
                    if(!empty($this->password)){
                        $con['password']     =  'required|min:8';
                    }

                    if(!empty($this->profile_pic)){
                        $con['profile_pic']     = 'required|image|mimes:jpeg,png,jpg,gif|max:2048';
                    }
                    return $con; 
                    
                break;

                default:
                    return  ['action2'   => 'required'];
            }

        }else{
            return  ['action'   => 'required|min:3|regex:/^([^0-9]*)$/'];
        }
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status'    => "failed",
            'msg'       => 'Validation errors',
            'data'      => $validator->errors()->all(),
        ]));
    }

    public function messages()
    {
        return [
            // 'fname.required'        => 'Full name is required',
            // 'fname.min'             => 'Full name must be 3 character long!',
            // 'fname.regex'           => 'Full name must not have special characters!',

            // 'contact_no.required'   => 'Contact number is required!',
            // 'contact_no.numeric'    => 'Contact number must be numeric!',
            // 'contact_no.digits'     => 'Contact number must have 11 digits!',
            // 'contact_no.unique'     => 'Contact number has already been taken!',

            'password.required'     => 'Password field is required!',
            'password.min'          => 'Password must be 8 character long!',
            // 'role.required'         => 'Role is required use value i.e. Captain, Passenger!',

            'action.required'           => 'Action field is required!',
            'action2.required'           => 'Invalid action value!'
            
        ];
    }
}
    
