<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class LeaveRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

      if((isset($this->action)) && (($this->action) == "store") ){
        return [
            'subject'       => 'required|min:3',
            'reason'        => 'required|min:3',
            'leave_start'   => 'required|date',
            'leave_end'     => 'required|date|after:leave_start',
        ];
      }else{
        return [
            'name'          => ['min:3','required'],
            'reason'        => ['min:3','required'],
            'leave_start'   => ['date','required'],
            'leave_end'     => ['date','required','after:leave_start'],
        ];
      }   
    }

    public function messages()
    {
        return [
            'subject.required'          => 'The Subject is required',
            'subject.min'               => 'The Subject must be three or more character long',
            'reason.required'           => 'The Reason is required',
            'reason.min'                => 'The Reason must be three or more character long',
        ];
    }
}
