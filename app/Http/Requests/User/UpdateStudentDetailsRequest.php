<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Request;
use App\User;

class UpdateStudentDetailsRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = $this->getUserForUpdate();

        return [
            'department_id' => 'required',
            'option_id' => 'required',
            'program' => 'required',
            'sponsorship' => 'required'
        ];
    }

    /**
     * @return \Illuminate\Routing\Route|object|string
     */
    protected function getUserForUpdate()
    {
        return $this->route('user');
    }
}
