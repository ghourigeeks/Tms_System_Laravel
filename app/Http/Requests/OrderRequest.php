<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

      if((isset($this->action)) && (($this->action) == "store") ){
        return [
            'user_id'     => 'required',
            'name'        => 'required|min:3|unique:orders,name',
            'start_date'  => 'required',
            'start_time'  => 'required',
            'end_time'    => 'required|after:start_time',
            'category_id' => 'required',
            'client_id'   => 'required',
        ];
      }else{
        return [
            'user_id'     => ['required'],
            'name'        => ['min:3','required'],
            'start_date'  => ['required'],
            'start_time'  => ['required'],
            'end_time'    => ['required','after:start_time'],
            'category_id' => ['required'],
            'client_id'   => ['required'],
        ];
      }   
    }

    public function messages()
    {
        return [
            'user_id.required'          => 'The User name is required',
            'name.required'             => 'The Order name is required',
            'name.min'                  => 'The Order name must be three or more character long',
            'start_date.required'       => 'The Order date is required',
            'start_time.required'       => 'The Order start time is required',
            'end_time.required'         => 'The Order end time is required',
            'end_time.after' => 'The end time is must after start time',
            'category_id.required'      => 'The Order category is required',
            'client_id.required'        => 'The Client name is required',
            
        ];
    }
}
