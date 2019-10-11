<?php

namespace App\Http\Requests\Hostel;

use App\Http\Requests\Request;

class UpdateHostelRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $hostel = $this->route('hostel');

        return [
            'regno' => 'required|exists:users,username',
            'level' => 'required|unique:hostels,level,NULL,'.$hostel->id.',regno,'.$this->regno,
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
