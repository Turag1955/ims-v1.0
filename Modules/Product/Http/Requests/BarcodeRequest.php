<?php

namespace Modules\Product\Http\Requests;

use App\Http\Requests\FormRequest;



class BarcodeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        
        return [
            'product'     => 'required',
            'barcode_qty' => 'required | integer',
            'qty_row'     => 'required | integer',
        ];
    }

    public function messages()
    {
        return[
            'barcode_qty.required' => 'Number of Barcode Field is required',
            'qty_row.required'     => 'Quantity Each Row Field is required',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
