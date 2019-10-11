<?php

namespace App\Http\Requests\Registration;

use App\Http\Requests\Request;
use App\Registration;

class CreateRegistrationRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'regno' => 'required|exists:users,username|unique:registrations,regno,NULL,id,academic_year,'.$this->academic_year.',promotion_year,'.$this->level.',promotion_year,'.$this->level,
            'academic_year' => 'required',
            'promotion_year' => 'required',
            'level' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'regno.exists' => 'Registration number does not match any student',
            'regno.unique' => 'Student already registered in the selected academic year',
        ];
    }
}
