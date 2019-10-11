<?php

namespace App\Http\Requests\Department;

use App\Http\Requests\Request;

class CreateDepartmentRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:departments,name',
            'hod' => 'required'
        ];
    }
}
