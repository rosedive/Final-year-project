<?php

namespace App\Http\Requests\Result;

use App\Http\Requests\Request;

class UpdateResultRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $result = $this->route('result');

        return [
            'regno' => 'required|exists:users,username|unique:results,regno,' . $result->id . ',id,level,' . $this->level . ',term,' . $this->term,
            'marks' => 'required|numeric|max:100',
            'term' => 'required',
            'level' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'regno.exists' => 'Registration number does not match any student',
            'regno.unique' => 'Student results already exists',
        ];
    }
}
