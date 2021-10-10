<?php

namespace App\Http\Requests;

use App\Http\Requests\FormRequest;


class GeneralRequest extends FormRequest
{


    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'             => 'required | string',
            'address'           => 'required | string',
            'currency_code'     => 'required | string',
            'currency_symbol'   => 'required | string',
            'currency_position' => 'required | string',
            'invoice_number'    => 'required | integer',
            'invoice_prefix'    => 'required | string',
            'timezone'          => 'required | string',
            'datae_formate'     => 'required | string',
            'logo'              => 'required |image | mimes:jpg,png,jpeg',
            'favicon'           => 'required |image | mimes:png'

        ];
    }
}
