<?php

namespace App\Http\Requests\Clearance;

use App\Http\Requests\Request;

class CreateClearanceRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'regno' => 'required',
            'level' => 'required',
            'reason' => 'required'
        ];
    }
}
