<?php

namespace Modules\Supplier\Http\Requests;

use App\Http\Requests\FormRequest;


class SupplierRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules['name']         = ['required','string','unique:suppliers,name'];
        $rules['email']        = ['nullable','string','unique:suppliers,name'];
        $rules['phone']        = ['nullable','string','unique:suppliers,name'];
        $rules['company_name'] = ['nullable','string','unique:suppliers,name'];
        $rules['vat_number']   = ['nullable','string','unique:suppliers,name'];
        $rules['city']         = ['nullable','string','unique:suppliers,name'];
        $rules['state']        = ['nullable','string','unique:suppliers,name'];
        $rules['postal_code']  = ['nullable','string','unique:suppliers,name'];
        $rules['address']      = ['nullable','string','unique:suppliers,name'];
        $rules['country']      = ['nullable','string','unique:suppliers,name'];

        if(request()->update_id){
            $rules['name'][2] = 'unique:suppliers,name,'.request()->update_id;
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
