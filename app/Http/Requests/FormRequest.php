<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Foundation\Http\FormRequest as laravelRequest;

 abstract class FormRequest extends laravelRequest
{
   
    public abstract function authorize();
   
    public abstract function rules();

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 200)
        );
    }
   
}
