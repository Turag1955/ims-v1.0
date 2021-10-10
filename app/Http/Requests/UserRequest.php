<?php

namespace App\Http\Requests;

use App\Http\Requests\FormRequest;

class UserRequest extends FormRequest
{

    protected $rules = [];
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
        $this->rules['role_id']          = ['required', 'integer'];
        $this->rules['name']             = ['required', 'string'];
        $this->rules['email']            = ['required', 'string', 'email', 'unique:users,email'];
        $this->rules['mobile_no']        = ['required', 'string', 'unique:users,mobile_no'];
        $this->rules['gender']           = ['required', 'integer'];
        $this->rules['password']         = ['required', 'string', 'min:8'];
        $this->rules['confirm_password'] = ['required', 'string', 'min:8'];

        if (request()->update_id) {
            $this->rules['email'][3]         = 'unique:users,email,' . request()->update_id;
            $this->rules['mobile_no'][2]     = 'unique:users,mobile_no,' . request()->update_id;
            $this->rules['password']         = 'nullable';
            $this->rules['confirm_password'] = 'nullable';
        }
        return $this->rules;
    }
}
