<?php

namespace Modules\Category\Http\Requests;

use App\Http\Requests\FormRequest;

class CatagoryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        if (request()->update_id) {
            $rules['name'] = ['required', 'string', 'unique:categories,name,' . request()->update_id];
        } else {
            $rules['name'] = ['required', 'string', 'unique:categories,name'];
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
