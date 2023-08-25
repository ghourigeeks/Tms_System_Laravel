<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ContestRequest extends FormRequest
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
            'name'        => 'required|min:3|unique:contests,name',
            'contest_url' => 'required|url|unique:contests,contest_url',
            'start_date'  => 'required',
            'start_time'  => 'required',
            'end_time'    => 'required|after:start_time',
        ];
      }else{
        return [
            'user_id'     => ['required'],
            'name'        => ['min:3','required'],
            'contest_url' => ['required','url'],
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
            'contest_url.required'   => 'The Contest url is required',
            'contest_url.url'        => 'The Contest url is invalid',
            'name.min'               => 'The Contest name must be three or more character long',
            'start_date.required'    => 'The Contest date is required',
            'start_time.required'    => 'The Contest start time is required',
            'end_time.required'      => 'The Contest end time is required',
            'end_time.after'         => 'The end time is must after start time',
            
        ];
    }
}
