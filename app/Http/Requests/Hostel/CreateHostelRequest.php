<?php

namespace App\Http\Requests\Hostel;

use App\Http\Requests\Request;
use App\User;

class CreateHostelRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'regno' => 'required|exists:users,username',
            'level' => 'required|unique:hostels,level,NULL,id,regno,'.$this->regno,
            'sponsorship' => 'required',
            'room' => 'required',
            'expected_amount' => 'required|numeric',
            'amount_paid' => 'required|numeric'
        ];
    }

    public function messages()
    {
        return [
            'regno.exists' => 'Registration number does not match any student',
            'level.unique' => 'Student has already paid for this year',
        ];
    }
}
