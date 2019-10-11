<?php

namespace App\Http\Requests\Option;

use App\Http\Requests\Request;

class UpdateOptionRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $option = $this->route('option');

        return [
            'name' => 'required|unique:dpt_options,name,'. $option->id,
            'department_id' => 'required'
        ];
    }
}
