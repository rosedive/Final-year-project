<?php

namespace App\Http\Requests\Clearance;

use App\Http\Requests\Request;

class UpdateClearanceRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $clearance = $this->route('clearance');

        return [
            'regno' => 'required',
            'level' => 'required',
            'reason' => 'required'
        ];
    }
}
