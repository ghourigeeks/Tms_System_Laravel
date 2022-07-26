<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;


class RoleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if((isset($this->action)) && (($this->action) == "store") ){
            return [
                'name'          => 'required|min:3|unique:roles,name',
                'permission'    => 'required',
            ];
          }else{
            return [
                'name'          => ['min:3','required', Rule::unique('roles')->ignore($this->role)],
                'permission'    => 'required',
            ];
        }
    }
}
    
