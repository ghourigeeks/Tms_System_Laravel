<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if((isset($this->action)) && (($this->action) == "store") ){
            $con    =   [
                            'client_id'         => 'required',
                            'name'              => 'required|min:3|unique:products,name',
                            'price'             => 'required|numeric',
                            'category_id'       => 'required',
                            'sub_category_id'   => 'required',
                        ];
            return $con; 
        }else{
            $con    =   [
                            'client_id'          => ['required'], 
                            'name'               => ['required','min:3'],
                            'price'              => ['required','numeric'],
                            'category_id'        => ['required'],
                            'sub_category_id'    => ['required'],

                        ];
            return $con; 
        }
    }

    public function messages()
    {
        return [
            'name.required'            => 'The product name is required',
            'name.min'                 => 'The product name must be three or more character long',
            'client_id.required'       => 'The client name is required',
            'category_id.required'     => 'The category name is required',
            'sub_category_id.required' => 'The subcategory name is required'
            
        ];
    }
}
