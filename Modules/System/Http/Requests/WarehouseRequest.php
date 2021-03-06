<?php

namespace Modules\System\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WarehouseRequest extends FormRequest
{
    protected $rules = [];
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->rules['name'] = ['required','string','unique:warehouses,name'];
        $this->rules['email'] = ['required','email','unique:warehouses,email'];
        $this->rules['phone'] = ['required','string','unique:warehouses,phone'];
        $this->rules['address'] = ['required','string'];


      
        if(request()->update_id){
            $this->rules['name'][2] = 'unique:warehouses,name,'.request()->update_id;
            $this->rules['email'][2] = 'unique:warehouses,email,'.request()->update_id;
            $this->rules['phone'][2] = 'unique:warehouses,phone,'.request()->update_id;

        }
        return $this->rules;
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
