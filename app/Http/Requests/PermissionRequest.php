<?php

namespace App\Http\Requests;

use App\Http\Requests\FormRequest;


class PermissionRequest extends FormRequest
{
    protected $rules    = [];
    protected $messages = [];

 
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
        $this->rules['module_id'] = ['required','integer'];
        
        $this->messages['module_id.required']                      = 'This Module Feild Required..!';
        $this->messages['module_id.integer']                       = 'This Module Feild Must Be integer..!';

        $collection = collect(request());
        if($collection->has('permission')){
            foreach (request()->permission as $key => $value) {
               $this->rules['permission.'.$key.'.name']             = ['required','string'];
               $this->rules['permission.'.$key.'.slug']             = ['required','string','unique:permissions,slug'];

               $this->messages['permission.'.$key.'.name.required'] = 'This Permission Name feilds Required..!';
               $this->messages['permission.'.$key.'.name.string']   = 'This Permission Name feilds Must Be string..!';

               $this->messages['permission.'.$key.'.slug.required'] = 'This Slug feilds Required..!';
               $this->messages['permission.'.$key.'.slug.string']   = 'This Slug feilds Must Be string..!';
               $this->messages['permission.'.$key.'.slug.unique']   = 'This Slug feilds Must Be uniquer..!';

    }
        }
        return $this->rules;

    }

    public function messages()
    {
        return $this->messages;
    }
}
