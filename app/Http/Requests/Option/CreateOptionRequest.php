<?php

namespace App\Http\Requests\Option;

use App\Http\Requests\Request;

class CreateOptionRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:dpt_options,name',
            'department_id' => 'required'
        ];
    }
}
