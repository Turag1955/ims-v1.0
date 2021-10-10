<?php

namespace Modules\Customer\Http\Requests;

use App\Http\Requests\FormRequest;



class CustomerRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules['name']              = ['required','string','unique:customers,name'];
        $rules['customer_group_id'] = ['required','integer'];

        $rules['email']        = ['nullable','email','string','unique:customers,email'];
        $rules['phone']        = ['nullable','string'];
        $rules['company_name'] = ['nullable','string'];
        $rules['tax_number']   = ['nullable','string'];
        $rules['city']         = ['nullable','string'];
        $rules['state']        = ['nullable','string'];
        $rules['postal_code']  = ['nullable','string'];
        $rules['address']      = ['nullable','string'];
        $rules['country']      = ['nullable','string'];

        if(request()->update_id){
            $rules['name'][2] = 'unique:customers,name,'.request()->update_id;
            $rules['email'][3] = 'unique:customers,email,'.request()->update_id;
        }
       return $rules;
    }

    public function messages()
    {
        return [
            'customer_group_id.required' => 'This customer group field is required'
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
