<?php

namespace Modules\Product\Http\Requests;

use App\Http\Requests\FormRequest;



class ProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules                      = [];
        $rules['name']              = ['required','string'];
        $rules['code']              = ['required','string','unique:products,code'];
        $rules['barcode_symbology'] = ['required','string'];
        $rules['image']             = ['nullable','image','mimes:jpg,png,jpeg'];
        $rules['brand_id']          = ['nullable'];
        $rules['category_id']       = ['required'];
        $rules['unit_id']           = ['required'];
        $rules['purchase_unit_id']  = ['required'];
        $rules['sale_unit_id']      = ['required'];
        $rules['cost']              = ['required','numeric','gt:0'];
        $rules['price']             = ['required','numeric','gt:0'];
        $rules['qty']               = ['nullable','numeric','gt:0'];
        $rules['alert_qty']         = ['nullable','numeric','gt:0'];
        $rules['tax_id']            = ['nullable'];
        $rules['tax_method']        = ['required'];
        $rules['description']       = ['required'];
        
        if(request()->update_id){
            $rules['code'][2] = 'unique:products,code,'.request()->update_id;
        }
        return $rules;

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
