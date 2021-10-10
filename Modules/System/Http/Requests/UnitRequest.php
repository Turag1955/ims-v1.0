<?php

namespace Modules\System\Http\Requests;

use App\Http\Requests\FormRequest;



class UnitRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'unit_code'       => 'required|string',
            'unit_name'       => 'required|string',
            'base_unit'       => 'nullable|integer',
            'operator'        => 'nullable|string',
            'operation_value' => 'nullable|numeric',
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
