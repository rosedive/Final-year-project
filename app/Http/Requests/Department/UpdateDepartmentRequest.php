<?php

namespace App\Http\Requests\Department;

use App\Http\Requests\Request;

class UpdateDepartmentRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $department = $this->route('department');

        return [
            'name' => 'required|unique:departments,name,'. $department->id,
            'hod' => 'required'
        ];
    }
}
