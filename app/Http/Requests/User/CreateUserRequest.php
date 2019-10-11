<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Request;
use App\User;

class CreateUserRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'email' => 'required|email|unique:users,email',
            'username' => 'required_with:student_details|nullable|unique:users,username',
            'password' => 'required|min:6|confirmed',
            'birthday' => 'nullable|date',
            'role_id' => 'required|exists:roles,id',
            'department_id' => 'required_with:student_details',
            'option_id' => 'required_with:student_details',
            'program' => 'required_with:student_details',
            'sponsorship' => 'required_with:student_details'
        ];
        
        return $rules;
    }
}
