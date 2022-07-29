<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class FaqRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if((isset($this->action)) && (($this->action) == "store") ){
            $con    =   [
                            'question'          => 'required|min:3|unique:faqs,question',
                            'description'       => 'required|min:3',
                        ];
            return $con; 
        }else{
            $con    =   [
                            'question'           => ['required','min:3'], 
                            'description'        => ['required','min:3'],

                        ];
            return $con; 
        }
    }

    public function messages()
    {
        return [
            'question.required'    => 'The question is required',
            'question.min'         => 'The question must be three or more character long',
            'description.required' => 'The description name is required',
            'description.min'      => 'The description name must be three or more character long',
            
        ];
    }
}
