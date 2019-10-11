<?php

namespace App\Http\Requests\Clearance;

use App\Http\Requests\Request;

class UpdateRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'decision' => 'required',
            'message' => 'required',
            'request_id' => 'required'
        ];
    }
}
