<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class RevisionRequest extends FormRequest
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
            'order_id'    => 'required',
            'start_date'  => 'required',
            'start_time'  => 'required',
            'end_time'    => 'required|after:start_time',
        ];
      }else{
        return [
            'user_id'     => ['required'],
            'order_id'    => ['required'],
            'start_date'  => ['required'],
            'start_time'  => ['required'],
            'end_time'    => ['required','after:start_time'],
        ];
      }   
    }

    public function messages()
    {
        return [
            'user_id.required'       => 'The User name is required',
            'order_id.required'      => 'The Revision name is required',
            'name.min'               => 'The Revision name must be three or more character long',
            'start_date.required'    => 'The Revision date is required',
            'start_time.required'    => 'The Revision start time is required',
            'end_time.required'      => 'The Revision end time is required',
            'end_time.after'         => 'The end time is must after start time',
            
        ];
    }
}
