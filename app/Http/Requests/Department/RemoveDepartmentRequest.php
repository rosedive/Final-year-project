<?php

namespace App\Http\Requests\Department;

use App\Http\Requests\Request;

class RemoveDepartmentRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->route('department')->removable;
    }

    public function rules()
    {
        return [];
    }
}
